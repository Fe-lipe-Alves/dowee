<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Obtém a imagem de perfil
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Obtém lista de faixas favoritadas pelo usuário
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Obtém compartilhamentos para este usuário
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shares()
    {
        return $this->hasMany(SharedPlaylist::class);
    }

//    /**
//     * Obtém lista de playlists criadas pelo usuário
//     *
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function playlists()
//    {
//        return $this->hasMany(Playlist::class);
//    }

    public function playlists()
    {
        return $this->hasManyThrough(
            Playlist::class,
            SharedPlaylist::class,
            'user_id',
            'id',
            'id',
            'playlist_id'
        );
    }
}
