<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistTrack extends Model
{
    /**
     * Propriedades permitidas para atribuição em massa
     *
     * @var string[]
     */
    protected $fillable = [
        'playlist_id',
        'track_deezer_id',
    ];

    /**
     * Obtém o objeto de playlist
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}
