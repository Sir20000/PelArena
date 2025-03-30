<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
class ServerOrder extends Model
{
    use HasFactory;

    protected $fillable =  ['user_id',
                            'server_name',
                            'status',
                            'ram',
                            'cpu',
                            'storage',
                            'db',
                            'allocations',
                            'backups',
                            'cost',
                            'paypal_order_id',
                            'server_id',
                            'renouvelle',
                            'categorie'
                          ];
    protected $casts =    [
                            'renouvelle' => 'datetime',
                          ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
}
