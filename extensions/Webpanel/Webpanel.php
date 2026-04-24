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
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ])->$method($url, $data);

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
        $response = $this->callApi('get', 'users');
        return $response !== null;
    }

    public function createUser(array $data)
    {
        $users = $this->callApi('get', 'users');
        if (!$users)
            return false;

        $existingUser = collect($users)->firstWhere('email', $data['email']);

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
        $users = $this->callApi('get', 'users');
        $user = collect($users)->firstWhere('email', $data['email']);

        if (!$user) {
            $this->createUser(['name' => $data['email'], 'email' => $data['email']]);
            $users = $this->callApi('get', 'users');
            $user = collect($users)->firstWhere('email', $data['email']);
        }

        if (!$user)
            return false;

        $extension_fields = $data['extension_fields'] ?? [];

        $response = $this->callApi('post', 'sites', [
            'name' => $data['server_name'] ?? $extension_fields['dns'] ?? ('Site ' . \Illuminate\Support\Str::random(5)),
            'dns' => $extension_fields['dns'] ?? ($data['server_name'] . '.webpanel.test'),
            'user_id' => $user['id'],
            'description' => 'Created via Pelarena',
            'php_version' => $extension_fields['php_version'] ?? '8.2'
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

    public function getFieldsNeeded(): array
    {
        return [
            'dns' => ["type" => 'text', 'name' => 'Domain Name (DNS)'],
            'php_version' => [
                "type" => 'select',
                'name' => 'PHP Version',
                'options' => [
                    '8.1' => 'PHP 8.1',
                    '8.2' => 'PHP 8.2',
                    '8.3' => 'PHP 8.3',
                ]
            ],
        ];
    }

    public function getFieldsCategorieNeeded(): array
    {
        return [
            'default_php_version' => [
                "type" => 'select',
                'name' => 'Default PHP Version',
                'options' => [
                    '8.1' => 'PHP 8.1',
                    '8.2' => 'PHP 8.2',
                    '8.3' => 'PHP 8.3',
                ],
                "information" => true,
                "icon" => "ri-code-s-slash-line"
            ],
        ];
    }
    public function index()
    {
        return view("extensions.Webpanel::dashboard");
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