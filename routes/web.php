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

        $router->get('/events/{event_id}/voters', 'VoterController@index'); // TODO: GET IS CANDIDATE FOR EACH VOTER
        $router->post('/events/{event_id}/join', 'VoterController@storeByEvent');
        $router->put('/events/{event_id}/voters/{id}', 'VoterController@update');

        $router->get('/events/{event_id}/candidates', 'CandidateController@index'); // TODO : GET VOTE COUNT FOR EACH CANDIDATE
        $router->post('/events/{event_id}/candidates', 'CandidateController@store');
        $router->put('/events/{event_id}/candidates/{id}', 'CandidateController@update');
        $router->delete('/events/{event_id}/candidates/{id}', 'CandidateController@destroy');
        $router->get('/events/{event_id}/candidates/{id}', 'VoteController@show'); //TODO : GET VOTE COUNT PER CANDIDATE

        $router->post('/events/{event_id}/candidates/{id}/votes', 'VoteController@store');
    });
});
