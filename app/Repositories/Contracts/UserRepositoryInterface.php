<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Valida, cria ou atualiza um registor de usuário
     *
     * @param array $data
     * @param int|null $userId
     * @return array
     */
    public function store(array $data, int $userId = null): array;

    /**
     * Aplica regras de validação nos dados recebido
     *
     * @param array $data
     * @param int|null $userId
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $data, int $userId = null);
}
