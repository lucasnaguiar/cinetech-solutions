<?php

use Pecee\SimpleRouter\SimpleRouter;


SimpleRouter::setDefaultNamespace('App\\Controllers');

SimpleRouter::get('/', callback: function () {
    http_response_code(404);
    return 'not found';
});

SimpleRouter::get('/api', callback: function () {
    http_response_code(404);
    return 'not found';
});

SimpleRouter::get('/info-php', callback: function () {
    return phpinfo();
});

SimpleRouter::group(['prefix' => '/api'], callback: function () {
    SimpleRouter::post('/login', callback: 'AuthController@login');

    SimpleRouter::get('/genres', callback: 'GenreController@index');
    SimpleRouter::post('/genres', callback: 'GenreController@store');
    SimpleRouter::get('/genres/{id}', callback: 'GenreController@show');
    SimpleRouter::patch('/genres/{id}', callback: 'GenreController@update');
    SimpleRouter::delete('/genres/{id}', callback: 'GenreController@destroy');

    SimpleRouter::get('/movies', callback: 'MovieController@index');
    SimpleRouter::post('/movies', callback: 'MovieController@store');
    SimpleRouter::get('/movies/{id}', callback: 'MovieController@show');
    SimpleRouter::patch('/movies/{id}', callback: 'MovieController@update');
    SimpleRouter::post('/movies/{id}/update-cover', callback: 'MovieController@updateCover');
    SimpleRouter::delete('/movies/{id}', callback: 'MovieController@destroy');
});
