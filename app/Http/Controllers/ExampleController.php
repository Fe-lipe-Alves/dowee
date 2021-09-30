<?php

namespace App\Http\Controllers;

use App\Services\Deezer;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function get()
    {
        $deezer = new Deezer();
        $response = $deezer->chart();
        return response()->json($response);
    }
}
