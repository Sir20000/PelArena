<?php

namespace Extensions\Webpanel;

use App\Models\ExtensionConfig;
use App\Extensions\ExtensionField;

class Webpanel
{
    public $author = 'Sir_200';
    public $version = '1.0.0';
    public $description = 'Extension de gestion de sites pour Pelarena utilisant l\'API KantumHost Webpanel.';
    public $util = 'server';

    public function boot(): void
    {
        $fields = [
            [
                'key' => 'api_url',
                'type' => 'text',
                'label' => 'Webpanel API URL',
                'default' => 'https://your-webpanel.com'
            ],
            [
                'key' => 'api_token',
                'type' => 'password',
                'label' => 'Admin API Token',
                'default' => ''
            ],
        ];
        ExtensionField::register(strtolower('Webpanel'), $fields);

        foreach ($fields as $field) {
            ExtensionConfig::firstOrCreate(
                ['extension' => strtolower('Webpanel'), 'key' => $field['key']],
                ['value' => $field['default'] ?? '']
            );
        }
    }

    public function getConfig(string $key, $default = null)
    {
        return ExtensionConfig::where('extension', strtolower('Webpanel'))
            ->where('key', $key)
            ->value('value') ?? $default;
    }

    public function setConfig(string $key, $value): void
    {
        ExtensionConfig::updateOrCreate(
            ['extension' => strtolower('Webpanel'), 'key' => $key],
            ['value' => $value]
        );
    }

    private function callApi($method, $endpoint, $data = [])
    {
        $url = rtrim($this->getConfig('api_url'), '/') . '/api/admin/' . ltrim($endpoint, '/');
        $token = $this->getConfig('api_token');

        try {
            $request = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ]);

            if ($method === 'get' && !empty($data)) {
                $response = $request->get($url, $data);
            } else {
                $response = $request->$method($url, $data);
            }

            if ($response->failed()) {
                \Log::error("Webpanel API Error ($method $endpoint): " . $response->body());
                return null;
            }

            return $response->json();
        } catch (\Exception $e) {
            \Log::error("Webpanel API Exception ($method $endpoint): " . $e->getMessage());
            return null;
        }
    }

    public function testConfig()
    {
        $response = $this->callApi('get', 'users', ['limit' => 1]);
        return $response !== null;
    }

    public function createUser(array $data)
    {
        $users = $this->callApi('get', 'users', ['email' => $data['email']]);

        if ($users === null)
            return false;

        $existingUser = collect($users)->first();

        if (!$existingUser) {
            $response = $this->callApi('post', 'users', [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'] ?? \Illuminate\Support\Str::random(12),
                'admin' => 0
            ]);
            return isset($response['user']) ? true : false;
        }

        return true;
    }

    public function createServer(array $data)
    {
        // 1. Get or create user
        $users = $this->callApi('get', 'users', ['email' => $data['email']]);
        $user = collect($users)->first();

        if (!$user) {
            $this->createUser(['name' => $data['email'], 'email' => $data['email']]);
            $users = $this->callApi('get', 'users', ['email' => $data['email']]);
            $user = collect($users)->first();
        }

        if (!$user)
            return false;

        // fields from order (user choice)
        $extension_fields = $data['extension_fields'] ?? [];
        // fields from product/category (admin config)
        $category_fields = $data['extension_fields_categorie'] ?? $data['category_fields'] ?? $extension_fields;

        $dns = $extension_fields['dns'] ?? ($data['server_name'] . '.webpanel.test');
        $php_version = $extension_fields['php_version'] ?? $category_fields['php_version'] ?? '8.2';
        $storage_max = $category_fields['disk'] ?? 1024; // Default 1GB

        // 2. Check if site already exists by DNS
        $existingSites = $this->callApi('get', 'sites', ['dns' => $dns]);

        if (collect($existingSites)->isNotEmpty()) {
            return [
                'info' => [
                    'site_id' => $existingSites[0]['id']
                ]
            ];
        }

        // 3. Create site
        $response = $this->callApi('post', 'sites', [
            'name' => $data['server_name'] ?? $dns,
            'dns' => $dns,
            'user_id' => $user['id'],
            'description' => 'Created via Pelarena',
            'php_version' => $php_version,
            'storage_max' => $storage_max,
        ]);

        if ($response && isset($response['site'])) {
            return [
                'info' => [
                    'site_id' => $response['site']['id']
                ]
            ];
        }

        return false;
    }

    public function deleteServer(array $data)
    {
        $siteId = $data['info']['site_id'] ?? null;
        if (!$siteId)
            return false;

        return $this->callApi('delete', "sites/$siteId") !== null;
    }

    public function suspendServer(array $data)
    {
        $siteId = $data['info']['site_id'] ?? null;
        if (!$siteId)
            return false;

        return $this->callApi('put', "sites/$siteId", ['status' => 'suspended']) !== null;
    }

    public function unsuspendServer(array $data)
    {
        $siteId = $data['info']['site_id'] ?? null;
        if (!$siteId)
            return false;

        return $this->callApi('put', "sites/$siteId", ['status' => 'active']) !== null;
    }

    public function getSiteStats($siteId)
    {
        return $this->callApi('get', "sites/$siteId");
    }

    private function getPhpVersions(): array
    {
        $cacheKey = 'webpanel_php_versions';

        // Cache for 1 hour to avoid excessive API calls
        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function () {
            $response = $this->callApi('get', 'system/versions');

            if (!$response || !isset($response['php_versions'])) {
                return [
                    '8.1' => 'PHP 8.1',
                    '8.2' => 'PHP 8.2',
                    '8.3' => 'PHP 8.3',
                ];
            }

            $options = [];
         $options = [];

foreach ($response['php_versions'] as $version) {
    $options[] = [
        "id" => $version,
        "name" => "PHP " . $version
    ];
}
            return $options;
        });
    }

    public function getFieldsNeeded(): array
    {
        // Retourne les champs nécessaires pour créer un serveur (remplis par le client)
        return [
            'dns' => ["type" => 'text', 'name' => 'Domain Name (DNS)'],
            'php_version' => [
                "type" => 'select',
                'name' => 'PHP Version',
                'options' => $this->getPhpVersions(),
            ],
        ];
    }

    public function getFieldsCategorieNeeded(): array
    {
        // Retourne les champs nécessaires pour créer un produit (remplis par l'admin)
        return [
            'disk' => ["type" => 'number', 'name' => 'Disk (MIB)', "information" => false, "icon" => "ri-hard-drive-3-line"],
            'php_version' => [
                "type" => 'select',
                'name' => 'Default PHP Version',
                "information" => true,
                "icon" => "ri-code-s-slash-line",
                'options' => $this->getPhpVersions(),
            ],
        ];
    }

    public function index()
    {
        $stats = [
            'sites_count' => count($this->callApi('get', 'sites') ?? []),
            'users_count' => count($this->callApi('get', 'users') ?? []),
            'api_status' => $this->testConfig() ? 'Online' : 'Offline',
        ];

        return view("extensions.Webpanel::dashboard", compact('stats'));
    }

    public function managerserver($server)
    {
        $siteId = $server['info']['site_id'] ?? null;
        if (!$siteId) {
            return redirect()->back()->with('error', 'Site ID not found.');
        }

        $url = rtrim($this->getConfig('api_url'), '/') . '/manage/' . $siteId;
        return redirect()->away($url);
    }
}