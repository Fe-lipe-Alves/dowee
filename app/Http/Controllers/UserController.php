<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @param int|null $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, int $userId = null)
    {
        $store = $this->repository->store($request->all(), $userId);

        if ($store['success']) {
            return response()->json($store, Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'errors' => $store['errors'],
        ]);
    }

    /**
     * Obtém os dados de determinado usuário
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $userId)
    {
        $user = $this->repository->get($userId);

        if (is_null($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * Obtém lista de playlists criadas e compartilhadas pelo usuário
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function playlists()
    {
        $playlists = $this->repository->allByUser();

        return response()->json($playlists);
    }
}
