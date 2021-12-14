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
// */

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'V1'], function () use ($router) {
        $router->group(['prefix' => 'author'], function () use ($router) {
            $router->get('', 'Api\V1\AuthorController@index');
            $router->post('', 'Api\V1\AuthorController@store');
            $router->get('{id}', 'Api\V1\AuthorController@show');
            $router->get('{id}/edit', 'Api\V1\AuthorController@edit');
            $router->put('{id}', 'Api\V1\AuthorController@update');
            $router->delete('{id}', 'Api\V1\AuthorController@destroy');
        });

        $router->group(['prefix' => 'article'], function () use ($router) {
            $router->get('', 'Api\V1\ArticleController@index');
            $router->post('', 'Api\V1\ArticleController@store');
            $router->get('{id}', 'Api\V1\ArticleController@show');
            $router->get('{id}/edit', 'Api\V1\ArticleController@edit');
            $router->put('{id}', 'Api\V1\ArticleController@update');
            $router->delete('{id}', 'Api\V1\ArticleController@destroy');
            return $router->app->version();
        });
    });
});
