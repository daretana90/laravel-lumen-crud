<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\UserController;

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



// $router->get('/users', UserController::index);

// Route::get('/greeting', function () {
//     return 'Hello World';
// });

// Funciona
// Route::get('/users', 'UserController@index');

// $router->post('/users',
//     ['uses' => 'UserController@create']
// );

$router->post('/auth-login', 
    ['uses' => 'AuthController@authenticate']
);

$router->group(
    ['prefix' => 'api'],
    function () use ($router) {
        // $router->get('users', ['uses' => 'UserController@index', 'middleware'=>'jwt.auth']);
        $router->get('users', ['uses' => 'UserController@index']);
        // $router->post('users', ['uses' => 'UserController@create', 'middleware'=>'jwt.auth']);
        $router->post('users', ['uses' => 'UserController@create']);
        // $router->get('user/{id}[0-9]', ['uses' => 'UserController@show', 'middleware'=>'jwt.auth']);
        $router->get('user/{id}[0-9]', ['uses' => 'UserController@show']);
        // $router->put('user/{id}[0-9]', ['uses' => 'UserController@update', 'middleware'=>'jwt.auth']);
        $router->put('user/{id}[0-9]', ['uses' => 'UserController@update']);
        // $router->delete('user/{id}[0-9]', ['uses' => 'UserController@destroy', 'middleware'=>'jwt.auth']);
        $router->delete('user/{id}[0-9]', ['uses' => 'UserController@destroy']);
});
