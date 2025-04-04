<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories_tickets';

    protected $fillable = ['name', 'priority'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
