<?php

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

$router->get('/teams', 'TeamController@index');
$router->post('/teams', 'TeamController@store');
$router->get('/teams/{team_id}', 'TeamController@show');
$router->put('/teams/{team_id}', 'TeamController@update');
$router->delete('/teams/{team_id}', 'TeamController@destroy');

$router->get('/users', 'UserController@index');
$router->post('/users', 'UserController@store');
$router->get('/users/{user_id}', 'UserController@show');
$router->put('/users/{user_id}', 'UserController@update');
$router->delete('/users/{user_id}', 'UserController@destroy');
