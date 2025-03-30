<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'reduction','one_for_user',"max_usage",'expire_time'];
    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }
    

}
