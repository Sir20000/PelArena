<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB; // Ajout de DB pour les insertions
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->json('permissions'); // Contiendra les routes accessibles
            $table->timestamps();
        });

        // Insérer les rôles par défaut
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'permissions' => json_encode(['*']), // Accès complet
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user',
                'permissions' => json_encode([]), // Aucun accès spécifique par défaut
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
