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


// Redirect all get requests to the github repo
$router->get('/{route:.*}', function () use ($router) {
    return redirect(env('GITHUB_REPO'));
});
