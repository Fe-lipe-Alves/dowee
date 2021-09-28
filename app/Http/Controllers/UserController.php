<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $repository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * Direciona para o repositório salvar o objeto e retorna o JSON relativo ao resultado
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $userId = null)
    {
        $store = $this->repository->store($request->all(), $userId);

        if ($store['success']) {
            return response()->json($store);
        }

        return response()->json([
            'success' => false,
            'errors' => $store['errors'],
        ]);
    }
}
