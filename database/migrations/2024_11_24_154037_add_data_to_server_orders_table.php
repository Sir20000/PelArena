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
        Schema::table('server_orders', function (Blueprint $table) {
            $table->float('cost')->nullable();
            $table->integer('ram')->nullable();
            $table->integer('cpu')->nullable();
            $table->integer('storage')->nullable();
            $table->integer('db')->nullable();
            $table->integer('allocations')->nullable();
            $table->integer('backups')->nullable();
            
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('server_orders', function (Blueprint $table) {
            //
        });
    }
};
