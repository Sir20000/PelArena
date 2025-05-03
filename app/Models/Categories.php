<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'egg_id',
        'nests',
        'created_at',
        'update_at',
        'nodeid',
        'maxram',
        'maxcpu',
        'maxstorage',
        'maxdb',
        'maxbackups',
        'maxallocations',
        'maxbyuser',
        'stock',
        'extension',

        'extension_fields', // new JSON column for dynamic fields
    ];

    public function prix()
    {
        return $this->hasMany(Prix::class, 'categories_id');
    }

    protected $casts = [
        'extension_fields' => 'array', // cast JSON to array
    ];
}
