<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () {
   return view('index');
});

$router->post('/auth/login', 'AuthController@postLogin');
$router->post('/auth/logout', 'AuthController@postLogout');
$router->post('users/create', 'UserController@store');

// Área bloqueada por login
$router->group(['middleware' => 'auth:api'], function () use ($router) {

    // Usuários
    $router->group(['prefix' => 'users'], function () use ($router) {

        $router->put('{userId}/update', 'UserController@store');
        $router->get('{userId}/show', 'UserController@show');
        $router->get('{userId}/playlists', 'UserController@playlists');

    });

    // Playlists
    $router->group(['prefix' => 'playlists'], function () use ($router) {

        $router->get('/', 'PlaylistController@index');
        $router->post('/create', 'PlaylistController@store');
        $router->put('/{playlistId}/update', 'PlaylistController@store');
        $router->post('/{playlistId}/show', 'PlaylistController@store');
        $router->delete('/{playlistId}/delete', 'PlaylistController@destroy');

    });

});
