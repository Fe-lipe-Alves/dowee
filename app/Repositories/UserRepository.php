<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Valida, cria ou atualiza um registor de usuário
     *
     * @param array $data
     * @param int|null $userId
     * @return array
     */
    public function store(array $data, int $userId = null): array
    {
        $validator = $this->validate($data, $userId);
        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors(),
            ];
        }

        if (is_null($userId)) {
            $user = new User();
            $user->password = Hash::make($data['password']);

            $message = 'Usuário cadastrado com sucesso. Faça o Login';
        } else {
            $user = User::query()->find($userId);
            $message = 'Usuário atualizado com sucesso';
        }

        $user->fill($data)->save();

        return [
            'success' => true,
            'message' => $message,
        ];
    }

    /**
     * Aplica regras de validação nos dados recebido
     *
     * @param array $data
     * @param int|null $userId
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $data, int $userId = null)
    {
        return Validator::make(
            $data,
            [
                'name'     => ['required'],
                'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
                'password' => ['required_without:id,null']
            ],
            [
            'name.required'             => 'Nome é um campo obrigatório',
            'email.required'            => 'E-mail é um campo obrigatório',
            'email.email'               => 'Insira um e-mail válido',
            'email.unique'              => 'Já existe um usuário com este e-mail',
            'password.required_without' => 'O campo senha é obrigatório',
            ]
        );
    }

    /**
     * Consulta por um ID de usuário específico
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function get(int $userId)
    {
        return User::query()->find($userId);
    }

    /**
     * Obtém as listas de playlists criadas e compartilhadas com o usuário
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
