<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SharedPlaylit extends Model
{
    /**
     * Propriedades permitidas para atribuição em massa
     *
     * @var string[]
     */
    protected $fillable = [
        'playlist_id',
        'user_id',
    ];

    /**
     * Obtém a playlis compartilahda
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }

    /**
     * Obtém o usuário a qual está compartilhado
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
