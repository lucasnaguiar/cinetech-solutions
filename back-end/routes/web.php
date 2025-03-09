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
    SimpleRouter::get('/products', callback: 'ProductController@index');
    SimpleRouter::post('/products', callback: 'ProductController@store');
    SimpleRouter::get('/products/{product}', callback: 'ProductController@show');
});
