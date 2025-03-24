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
    SimpleRouter::get('/genres', callback: 'GenreController@index');
    SimpleRouter::post('/genres', callback: 'GenreController@store');
    SimpleRouter::get('/genres/{genre}', callback: 'GenreController@show');
    SimpleRouter::patch('/genres/{genre}', callback: 'GenreController@update');
    SimpleRouter::delete('/genres/{genre}', callback: 'GenreController@destroy');

    SimpleRouter::get('/movies/{genre?}', callback: 'MovieController@index');
    SimpleRouter::post('/movies', callback: 'MovieController@store');
    SimpleRouter::get('/movies/{genre}', callback: 'MovieController@show');
    SimpleRouter::patch('/movies/{genre}', callback: 'MovieController@update');
    SimpleRouter::delete('/movies/{genre}', callback: 'MovieController@destroy');
});
