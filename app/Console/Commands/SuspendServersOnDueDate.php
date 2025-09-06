<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ServerOrder;
use Illuminate\Support\Facades\Http;
use App\Extensions\ExtensionManager;
Use App\Models\Product;
class SuspendServersOnDueDate extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'servers:suspend-due';

    /**
     * The console command description.
     */
    protected $description = 'Suspend servers whose renewal date has been reached';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString(); // Obtenir la date actuelle (au format AAAA-MM-JJ)

        $orders = ServerOrder::where('renouvelle', $today)
            ->where('status', '!=', 'pending') // Éviter de retraiter ceux déjà en 'pending'
            ->get();
            if(count($orders) == 0){
                return 0;

            }
        $bar = $this->output->createProgressBar(count($orders));
        $bar->start();

        foreach ($orders as $order) {
            $user = $order->user;
            $cost = $order->cost;
            if ($user->credit >= $cost) {
                $user->update(['credit' => $user->credit - $cost]);
                $newRenewDate = now()->addMonth()->toDateString();
                $order->update([
                    'renouvelle' => $newRenewDate,
                    'status' => 'active', // Mettre le statut à 'active'
                ]);

                $this->info("Server ID {$order->server_id} {$user} {$user->credit} renewed until {$newRenewDate}.");
            } else {
                $order->update(['status' => 'pending']);

                $productId = $order->product_id;

                $product = Product::find($productId);

                   $provider = ExtensionManager::load($product->extension);

        if ($provider) {
            $provider->suspendServer($order->extension_fields["info"]);

        }

               
            }
            $bar->advance();
        }
        $bar->finish();
    }
}
