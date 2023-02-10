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

$router->get('/', function () use ($router) {
    return response()->json([
        'status' => 'success',
        'message' => 'Welcome to API Sistem Monitoring Air Kolam Budidaya Udang',
        'data' => [
            'author' => 'Muhammad Umar Mansyur',
            'email' => 'umar.ovie@gmail.com',	
            'github' => 'github.com/UmarMansyur',
        ]
    ]);
});
$router->group(['prefix' => 'api'], function($router) {
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->get('user-profile', 'AuthController@me');
   
    $router->group(['prefix' => 'user'], function($router) {
        $router->get('/', 'UserController@show');
        $router->get('show/{id}', 'UserController@showById');
        $router->post('create', 'UserController@create');
        $router->put('update/{id}', 'UserController@update');
        $router->delete('delete/{id}', 'UserController@destroy');
    });
    $router->group(['prefix' => 'pond'], function($router) {
        $router->get('/', 'PondController@show');
        $router->get('show/{id}', 'PondController@showById');
        $router->post('create', 'PondController@create');
        $router->put('update/{id}', 'PondController@update');
        $router->delete('delete/{id}', 'PondController@destroy');
    });
    $router->group(['prefix' => 'anco-type'], function($router) {
        $router->get('/', 'AncoController@show');
        $router->get('show/{id}', 'AncoController@showById');
        $router->post('create', 'AncoController@create');
        $router->put('update/{id}', 'AncoController@update');
        $router->delete('delete/{id}', 'AncoController@destroy');
    });
    $router->group(['prefix' => 'anco'], function($router) {
        $router->get('/', 'DetailAncoController@show');
        $router->get('show/today', 'DetailAncoController@showToday');
        $router->get('show/{id}', 'DetailAncoController@showById');
        $router->post('create', 'DetailAncoController@create');
        $router->put('update/{id}', 'DetailAncoController@update');
        $router->delete('delete/{id}', 'DetailAncoController@destroy');
    });
    $router->group(['prefix' => 'kimia'], function ($router) {
        $router->get('/', 'KimiaController@show');
        $router->get('show/today', 'KimiaController@showToday');
        $router->get('show/{id}', 'KimiaController@showById');
        $router->post('create', 'KimiaController@create');
        $router->put('update/{id}', 'KimiaController@update');
        $router->delete('delete/{id}', 'KimiaController@destroy');
    });
    $router->group(['prefix' => 'pakan'], function ($router) {
        $router->get('/', 'FeedController@show');
        $router->get('show/today', 'FeedController@showToday');
        $router->get('show/{id}', 'FeedController@showById');
        $router->post('create', 'FeedController@create');
        $router->put('update/{id}', 'FeedController@update');
        $router->delete('delete/{id}', 'FeedController@destroy');
    });
    $router->group(['prefix' => 'air'], function ($router) {
        $router->get('/', 'WaterController@show');
        $router->get('show/today', 'WaterController@showToday');
        $router->get('show/{id}', 'WaterController@showById');
        $router->post('create', 'WaterController@create');
        $router->put('update/{id}', 'WaterController@update');
        $router->delete('delete/{id}', 'WaterController@destroy');
    });

});
