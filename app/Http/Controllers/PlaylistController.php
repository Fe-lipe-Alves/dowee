<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PlaylistRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    private $repository;

    public function __construct(PlaylistRepositoryInterface $playlistRepository)
    {
        $this->repository = $playlistRepository;
    }

    /**
     * Obtém lista de playlists criadas e compartilhadas pelo usuário logado
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $playlists = $this->repository->allByUser();

        return response()->json($playlists);
    }

    public function store(Request $request, int $playlistId = null)
    {
        $response = $this->repository->store($request->all(), $playlistId);
        return response()->json($response);
    }

    public function destroy(int $playlistId)
    {
        $response = $this->repository->delete($playlistId);
        return response()->json($response);
    }

    public function addUser(Request $request, int $playlistId)
    {
        $response = $this->repository->addUser($playlistId, $request->user_id);
        return response()->json($response);
    }
}
