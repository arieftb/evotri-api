<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\EventController;

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


$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->post('/users', 'UserController@store');
    $router->post('/users/login', 'CredentialController@login');

    $router->group(['middleware' => 'user.auth'], function () use ($router) {
        $router->post('/users/logout', 'CredentialController@destroy');
        $router->get('/users', 'UserController@index');
        $router->get('/users/{id}', 'UserController@show');
        $router->put('/users/{id}', 'UserController@update');
        $router->delete('/users/{id}', 'UserController@destroy');

        $router->get('/events', 'EventController@index');
        $router->get('/events/{id}', 'EventController@show');
        $router->post('/events', 'EventController@store');
        $router->put('/events/{id}', 'EventController@update');
        $router->delete('/events/{id}', 'EventController@destroy');

        // TODO : Change Function Name
        $router->post('/events/{event_id}/voters', 'VoterController@storeByEvent');

        $router->post('/events/{event_id}/voters/{voter_id}', 'EventAdminController@store');
    });
});
