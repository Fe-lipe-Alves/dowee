<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    /**
     * Propriedades permitidas para atribuição em massa
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    /**
     * Obtém a imagem de capa da playlist
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Obtém a lista de faixas da playlis
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tracks()
    {
        return $this->hasMany(PlaylistTrack::class);
    }

    /**
     * Obtém compartilhamentos desta playlist
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shares()
    {
        return $this->hasMany(SharedPlaylit::class);
    }

    /**
     * Obtém o autor da playlist
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
