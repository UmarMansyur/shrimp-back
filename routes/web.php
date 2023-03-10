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
    $router->patch('refresh', 'AuthController@refresh');
    $router->get('user-profile', 'AuthController@me');
   
    $router->group(['prefix' => 'user'], function($router) {
        $router->get('/', 'UserController@create');
        $router->post('create', 'UserController@register');
        $router->put('update/{id}', 'UserController@update');
        $router->delete('delete/{id}', 'UserController@destroy');
    });

});
