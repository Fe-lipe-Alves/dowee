<?php

namespace App\Repositories;

use App\Models\Playlist;
use App\Models\User;
use App\Repositories\Contracts\PlaylistRepositoryInterface;
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

        $created = $user->playlists()->with('image')->get();
        $shares = $user->shares()->with('image')->get();

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

        $playlist = Playlist::query()->updateOrCreate(['id' => $playlistId], $data);

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

        $playlists = $user->playlists()->where('id', $playlistId)->exists();
        $shares = $user->shares()->where('playlist_id', $playlistId)->exists();

        return $playlists || $shares;
    }

    public function delete(int $playlistId)
    {
        $playlist = Playlist::query()->find($playlistId);

        if (is_null($playlist)) {
            return [
                'success' => false,
                'message' => 'Playlist não encontrada'
            ];
        }

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
}
