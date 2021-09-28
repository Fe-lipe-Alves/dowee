<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $repository;

    public function __construct(UserRepository $userRepository)
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
