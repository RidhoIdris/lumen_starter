<?php
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['namespace' => 'App\Http\Controllers'], function ($api) {
    $api->get('/', function () use ($api) {
        return app()->version();
    });
    $api->post('auth/login', 'AuthController@login');

    $api->group(['middleware' => 'auth'], function ($api) {

        $api->post('auth/logout', 'AuthController@logout');
        $api->post('auth/refresh', 'AuthController@refresh');
        $api->post('auth/me', 'AuthController@me');

        $api->get('users', 'UserController@index');
        $api->post('users', 'UserController@store');
        $api->put('users/{id}', 'UserController@update');
        $api->delete('users', 'UserController@delete');

    });

});
