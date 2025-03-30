<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trensaction extends Model
{
    use HasFactory;
      protected $table = 'trensactions';
    protected $fillable =  [
    'cost',
    'user_id',
    'product',
    'server_order_id'
  ];
  public function user()
  {
      return $this->belongsTo(User::class);
  }
  public function product()
  {
      return $this->belongsTo(ServerOrder::class);
  }
}
