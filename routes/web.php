<?php

use \System\Router;

Router::csrfVerifier(new \App\Middlewares\CsrfVerifier());
Router::setDefaultNamespace('App\Controllers');

Router::group(['exceptionHandler' => '\\App\\Exceptions\\Handler'], function () {

    Router::get('/', 'HomeController@indexAction')->setName('home');
    Router::get('/home', 'HomeController@indexAction')->setName('home');

    // API
    Router::group(['prefix' => '/api', 'middleware' => \App\Middlewares\ApiVerification::class], function () {

        Router::get('/stats', 'ApiController@dashboardStatsAction');

    });

});






