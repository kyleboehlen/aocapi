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

// API Routes
$router->group(['prefix' => 'api', 'middleware' => 'throttle:' . env('REQUEST_LIMIT') . ',1'], function () use ($router) {
    // Version 1
    $router->group(['prefix' => 'v1'], function () use ($router) {
        // URL Params
        $router->post('/{year}/{day}/{part}/', ['uses' => 'AocController@index']);
    });
});

// Redirect all get requests to the github repo
$router->get('/{route:.*}', function () use ($router) {
    return redirect(env('GITHUB_REPO'));
});
