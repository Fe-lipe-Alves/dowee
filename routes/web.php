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

$router->group(['prefix' => 'users'], function () use ($router) {

    $router->post('store[/{userId}]', 'UserController@store');
    $router->get('show/{userId}', 'UserController@show');
    $router->get('{userId}/playlists', 'UserController@playlists');

});

$router->group(['prefix' => 'playlists'], function () use ($router) {

    $router->get('/', 'PlaylistController@index');

});
