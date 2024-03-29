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


// API route group
$router->group(['prefix' => 'api'], function () use ($router) {

    /////////////////////////// USERS /////////////////////////////

    // Matches "/api/register
    $router->post('register', 'AuthController@register');

    // Matches "/api/login
    $router->post('login', 'AuthController@login');

    // Matches "/api/profile
    $router->get('profile', 'UserController@profile');

    // Matches "/api/users/1
    //get one user by id
    $router->get('users/{id}', 'UserController@singleUser');

    // Matches "/api/users
    $router->get('users', 'UserController@index');

    // Matches Post "/api/users/reset-password
    $router->post('users/reset-password', 'AuthController@resetPassword');


    /////////////////////////// LICENCES /////////////////////////////

    // Matches "/api/licences
    $router->get('licences', 'LicenceController@index');

    // Matches Post "/api/licences register
    $router->post('licences', 'LicenceController@store');

    // Matches Put  "/api/licences pay licence
    $router->put('licences/{id}', 'LicenceController@pay');

    // Matches Put  "/api/licences activate licence
    $router->put('licences/activate/{id}', 'LicenceController@activate');

    // Matches Post "/api/licences/verify
    $router->post('licences/verify', 'LicenceController@verify');

    //////////////////////////////////////////////////////////////////

});
