<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recu extends Model
{
    protected $table = 'recu';

    protected $fillable = [
        'recu_id',
        'text_source',
        'payload_ia',
        'status',
    ];

    protected $attributes = [
        'status' => 'en_attente',
    ];

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'payload_ia' => 'array',
        ];
    }



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);

    }

    public function depences(): HasMany
    {
        return $this->hasMany(Depence::class);
    }
}
