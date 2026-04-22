<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('trensactions', function (Blueprint $table) {
            $table->float('cost')->change();  // Utilise 'text' pour des données plus longues
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trensaction', function (Blueprint $table) {
            //
        });
    }
};
