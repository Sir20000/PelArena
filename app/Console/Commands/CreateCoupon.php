<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coupon;

class CreateCoupon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-coupon 
                            {name : Le nom du coupon} 
                            {reduction : La réduction en pourcentage}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un nouveau coupon';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $reduction = $this->argument('reduction');

        // Validation basique
        if (!is_numeric($reduction) || $reduction <= 0 || $reduction > 100) {
            $this->error('La réduction doit être un nombre entre 0 et 100.');
            return;
        }

        // Vérifier si le coupon existe déjà
        if (Coupon::where('name', $name)->exists()) {
            $this->error("Le coupon '$name' existe déjà.");
            return;
        }

        // Créer le coupon
        Coupon::create([
            'name' => $name,
            'reduction' => $reduction,
        ]);

        $this->info("Le coupon '$name' avec une réduction de $reduction% a été créé avec succès!");
    }
}
