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
        Schema::create('prix', function (Blueprint $table) {
            $table->id();
            $table->float("ram");
            $table->float("cpu");
            $table->float("storage");
            $table->float("db");
            $table->float("backups");
            $table->float("allocations");
            $table->foreignId('categories_id')->constrained()->onDelete('cascade')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prix');
    }
};
