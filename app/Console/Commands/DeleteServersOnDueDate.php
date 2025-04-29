<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ServerOrder;
use Illuminate\Support\Facades\Http;

class DeleteServersOnDueDate extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'servers:delete-due';

    /**
     * The console command description.
     */
    protected $description = 'Delete servers whose delete date has been reached';

    /**
     * Execute the console command.
     */
    public function handle()
    {
$run = true;
        $orders = ServerOrder::where('status', 'pending')
            ->get();
            if(count($orders) == 0){
                $run = false;

            }
            if($run){
        $bar = $this->output->createProgressBar(count($orders));
        $bar->start();

        foreach ($orders as $order) {
            if ($order->status === 'pending' && $order->updated_at->diffInDays(now()) >= settings("deleteafterpending")) {
                $serverId = $order->server_id;

                // Suppression du serveur sur le panel Pterodactyl
                $deleteResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])->delete(env('PTERODACTYL_API_URL') . "/api/application/servers/{$serverId}");

                if ($deleteResponse->successful()) {
                    $order->delete();

                    $this->info("Server ID {$serverId} deleted after 21 days in pending status.\n");
                } else {

                    $this->error("Failed to delete server ID {$serverId}. \n");
                }

                $bar->advance();
            }
            
            
        }
        $bar->finish();
    }
        echo("\n");
        $orders = ServerOrder::where('status',  'cancelled') // Éviter de retraiter ceux déjà en 'pending'
            ->get();
            if(count($orders) == 0){
                return 0;

            }
        $bar = $this->output->createProgressBar(count($orders));
        $bar->start();

        foreach ($orders as $order) {
            if ($order->status === 'cancelled' ) {
              $serverId = $order->server_id;
                    $order->delete();
                    $this->info("Server ID {$serverId} deleted becose his is canceled.");
             

                $bar->advance();
            }
           
        }
         
        $bar->finish();
        echo("\n");
    }
}
