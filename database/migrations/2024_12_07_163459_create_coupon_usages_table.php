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
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // L'utilisateur qui utilise le coupon
            $table->foreignId('coupon_id')->constrained()->onDelete('cascade'); // Le coupon utilisé
            $table->foreignId('server_orders_id')->constrained()->onDelete('cascade'); // Le produit concerné
            $table->timestamps();

            $table->unique(['user_id', 'coupon_id', 'server_orders_id'], 'unique_coupon_usage'); // Empêche les doublons
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
    }
};
