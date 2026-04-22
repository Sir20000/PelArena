<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extension_configs', function (Blueprint $table) {
            $table->id();
            $table->string('extension'); // Ex: "pterodactyl"
            $table->string('key');       // Ex: "api_url"
            $table->text('value')->nullable(); // Ex: "https://panel.exemple.com"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extension_configs');
    }
};
