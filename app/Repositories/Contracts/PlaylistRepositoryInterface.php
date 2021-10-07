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

    /**
     * Cria ou atualiza um registro de playlists
     *
     * @param array $data
     * @param int|null $playlistId
     * @return array
     */
    public function store(array $data, int $playlistId = null): array;

    /**
     * Aplica regras de validação nos dados recebido
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $data);

    /**
     * Valida se o usuário logado é responsável pela playlist ou é uma de suas playlists compartilhadas
     *
     * @param int $playlistId
     * @return bool
     */
    public function isAuth(int $playlistId): bool;

    /**
     * Deleta um registro de playlist
     *
     * @param int $playlistId
     * @return array
     */
    public function delete(int $playlistId): array;
}
