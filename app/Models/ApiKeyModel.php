<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKeyModel extends Model
{
    /** @use HasFactory<\Database\Factories\ApiKeyModelFactory> */
    use HasFactory;
    protected $table = 'api_key';
    protected $fillable = [
        'user_id',
        'key_type',
        'token',
        'memo',
        'permision'
        ];

        
    protected $casts = [
        'permision' => 'array',
    ];

}
