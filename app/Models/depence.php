<?php

namespace App\Models;

use App\Enums\Categorie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Depence extends Model
{
    protected $table = 'depence';

    protected $fillable = [
        'recu_id',
        'libelle',
        'quantite',
        'prix_unitaire',
        'categorie',
    ];

    protected function casts(): array
    {
        return [
            'categorie' => Categorie::class,
        ];
    }

    public function recu(): BelongsTo
    {
        return $this->belongsTo(Recu::class);
    }
}
