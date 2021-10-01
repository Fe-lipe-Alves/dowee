<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PlaylistRepositoryInterface;
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
}
