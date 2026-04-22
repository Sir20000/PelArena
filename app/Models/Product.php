<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image','price','categorie','extension_fields','extension','stock','maxbyuser'];
public function categorie()
{
    return $this->belongsTo(Categories::class, 'categorie');
}



}
