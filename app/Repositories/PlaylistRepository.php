<?php

namespace App\Repositories;

use App\Models\Playlist;
use App\Models\SharedPlaylist;
use App\Models\User;
use App\Repositories\Contracts\PlaylistRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

        $created = $user->playlists()->get()->each(function ($item) {
            $item->image;
        });
        $shares = $user->shares()->get()->each(function ($item) {
            $item->image;
        });;

        return [
            'success' => true,
            'created' => $created,
            'shares'  => $shares,
        ];
    }

    /**
     * Cria ou atualiza um registro de playlists
     *
     * @param array $data
     * @param int|null $playlistId
     * @return array
     */
    public function store(array $data, int $playlistId = null): array
    {
        if (!is_null($playlistId) && !$this->isAuth($playlistId)){
            return [
                'success' => false,
                'message' => 'Usuário não permitido'
            ];
        }

        $validator = $this->validate($data);
        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors(),
            ];
        }

        $playlist = Playlist::query()->updateOrCreate(['id' => $playlistId], Arr::except($data, ['user_id']));
        $this->addUser($playlist->id, $data['user_id']);

        return [
            'success' => true,
            'playlist' => $playlist,
        ];
    }

    /**
     * Aplica regras de validação nos dados recebido
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $data)
    {
        return Validator::make(
            $data,
            [
                'name' => ['required'],
                'description' => ['nullable', 'max:150'],
                'user_id' => [
                    'required',
                    Rule::exists('users', 'id')
                ]
            ],
            [
                'name.required'   => 'Nome da playlist é obrigatório',
                'description.max' => 'Tamanho máximo da descrição é 150 caracteres',
                'user_id.exists'  => 'Usuário não identificado',
            ]
        );
    }

    /**
     * Valida se o usuário logado é responsável pela playlist ou é uma de suas playlists compartilhadas
     *
     * @param int $playlistId
     * @return bool
     */
    public function isAuth(int $playlistId): bool
    {
        /** @var User $user */
        $user = Auth::user();

        $playlists = $user->playlists()->where('playlists.id', $playlistId)->exists();
        $shares = $user->shares()->where('playlist_id', $playlistId)->exists();

        return $playlists || $shares;
    }

    /**
     * Deleta um registro de playlist
     *
     * @param int $playlistId
     * @return array
     */
    public function delete(int $playlistId): array
    {
        $playlist = Playlist::query()->find($playlistId);

        if (is_null($playlist)) {
            return [
                'success' => false,
                'message' => 'Playlist não encontrada'
            ];
        }

        SharedPlaylist::query()->where('shared_playlists.playlist_id', $playlistId)->delete();

        if ($playlist->delete()) {
            return [
                'success' => true,
                'message' => 'Playlist deletada'
            ];
        }

        return [
            'success' => false,
            'message' => 'Erro ao deletar playlist'
        ];
    }

    /**
     * Adiciona um usuário a playlist compartilhada
     *
     * @param int $playlistId
     * @param int $userId
     * @return array
     */
    public function addUser(int $playlistId, int $userId)
    {
        if (!Playlist::query()->where('id', $playlistId)->exists()) {
            return [
                'success' => false,
                'message' => 'Playlist não encontrada',
            ];
        }

        if (!User::query()->where('id', $userId)->exists()){
            return [
                'success' => false,
                'message' => 'Usuário não encontrado',
            ];
        }

        $share = new SharedPlaylist([
            'playlist_id' => $playlistId,
            'user_id' => $userId,
        ]);
        $share->save();

        return [
            'success' => true,
            'message' => 'Usuário adicionado com sucesso',
        ];
    }
}
