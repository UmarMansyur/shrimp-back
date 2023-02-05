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
    return $router->app->version();
});
$router->group(['prefix' => 'api'], function($router) {
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->get('user-profile', 'AuthController@me');
   
    $router->group(['prefix' => 'user'], function($router) {
        $router->get('/', 'UserController@show');
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

});
