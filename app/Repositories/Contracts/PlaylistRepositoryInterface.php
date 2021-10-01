<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface PlaylistRepositoryInterface
{
    /**
     * Obtém as listas de playlists criadas e compartilhadas
     *
     * @param User|null $user
     * @return array
     */
    public function allByUser(User $user = null): array;
}
