<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Deezer
{
    private $url = 'https://api.deezer.com';
    private $user = 'felipealves1550@gmail.com';
    private $password = 'felipe123';

    /**
     * Realiza uma requisição para o endpoint informado e trata o seu retorno
     *
     * @param $uri
     * @return array|mixed|null
     */
    public function request($uri)
    {
        if (empty($uri)) {
            return null;
        }

        $uri = $uri[0] == '/' ?: '/' . $uri;

        try {
            $request = Http::get($this->url . $uri);

            $response = $request->json();
        } catch (\Exception $exception) {
            $response = [
                'success' => false,
                'message' => 'Erro de conexão'
            ];
        }

        return $response;
    }

    public function chart($type = 'playlists')
    {
        return $this->request('chart/0/' . $type);
    }

    /**
     * Obtém as músicas em destaques
     *
     * @return array|mixed|null
     */
    public function editorial()
    {
        return $this->request('editorial');
    }
}
