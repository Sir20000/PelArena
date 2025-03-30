<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prix extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'prix';

    /**
     * Les colonnes qui peuvent être assignées en masse.
     *
     * @var array
     */
    protected $fillable = [
        'ram',
        'cpu',
        'storage',
        'db',
        'backups',
        'allocations',
        'categories_id',
    ];

    /**
     * Relation avec le modèle `Categorie`.
     */
    public function categorie()
    {
        return $this->belongsTo(Categories::class, 'categories_id');
    }
}
