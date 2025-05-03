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
            $table->dropColumn([
                'ram',
                'cpu',
                'storage',
                'db',
                'allocations',
                'backups',
                'server_id',

                
            ]);        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('server', function (Blueprint $table) {
            //
        });
    }
};
