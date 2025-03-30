<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            // Modifie la colonne 'settings' pour la rendre de type TEXT (ou VARCHAR(5000), selon ce dont vous avez besoin)
            $table->text('settings')->change();  // Utilise 'text' pour des données plus longues
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            // Vous pouvez revenir à une colonne 'string' si nécessaire
            $table->string('settings', 255)->change();  // Ajustez la taille si vous voulez limiter à 255 caractères
        });
    }
};
