<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtensionConfig extends Model
{
    protected $fillable = ['extension', 'key', 'value'];
}
