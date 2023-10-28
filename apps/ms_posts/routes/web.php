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

$router->group(['prefix' => 'api/posts'], function () use ($router) {
    //Commands
    $router->post('/', 'PostController@store');
    $router->patch('/{id}', 'PostController@update');
    $router->delete('/{id}', 'PostController@delete');
    //Queries
    $router->get('/',  'PostController@get');
    $router->get('/{id}',  'PostController@find');
});