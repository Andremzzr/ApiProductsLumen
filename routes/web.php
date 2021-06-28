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

$router->group(['prefix' => 'api'], function () use ($router){
    //GET ROUTES
    $router->get('/products', 'ProductController@index');
    $router->get('/products/{id}', 'ProductController@getSingle');
    $router->get('/products/name/{productName}', "ProductController@getName");
    $router->get('/products/tag/{tag}', "ProductController@getByTag");

    //DELETE ROUTES
    $router->delete('/products/{id}', 'ProductController@destroy');
    
    //PUT ROUTES
    $router->put('/products/{id}', "ProductController@update");
    
    //POST ROUTES
    $router->post('/products', 'ProductController@create');
    
    
});
