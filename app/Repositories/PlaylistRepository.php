<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\PlaylistRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PlaylistRepository implements PlaylistRepositoryInterface
{
    /**
     * Obtém as listas de playlists criadas e compartilhadas
     *
     * @param User|null $user
     * @return array
     */
    public function allByUser(User $user = null): array
    {
        $user = $user ?? Auth::user();

        if (is_null($user)) {
            return [
                'success' => false,
                'message' => 'Usuário não encontrado'
            ];
        }

        $created = $user->playlists()->with('image')->get();
        $shares = $user->shares()->with('image')->get();

        return [
            'success' => true,
            'created' => $created,
            'shares'  => $shares,
        ];
    }
}
