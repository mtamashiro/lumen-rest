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

$router->group(['namespace' => '\App\Api\Transaction\Controllers', 'prefix' => '/api'], function() use ($router)
{
    $router->post('transaction', 'TransactionController@transfer');
});

$router->group(['namespace' => '\App\Api\User\Controllers', 'prefix' => '/api'], function() use ($router)
{
    $router->get('user/{id}', 'UserController@show');
    $router->post('user', 'UserController@store');
});

$router->group(['namespace' => '\App\Api\Account\Controllers', 'prefix' => '/api'], function() use ($router)
{
    $router->get('account/{id}', 'AccountController@show');
    $router->post('account', 'AccountController@store');
});

