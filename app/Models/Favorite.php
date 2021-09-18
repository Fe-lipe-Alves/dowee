<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /**
     * Propriedades permitidas para atribuição em massa
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'track_deezer_id',
    ];

    /**
     * Obtém dono do favorito
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
