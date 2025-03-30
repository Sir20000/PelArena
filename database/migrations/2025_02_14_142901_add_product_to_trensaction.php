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
            $table->enum('product', ['credit', 'serveur', ]);
            $table->foreignId('server_order_id')->nullable()->constrained()->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trensactions', function (Blueprint $table) {
            //
        });
    }
};
