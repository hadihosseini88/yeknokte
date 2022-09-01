<?php

Route::group(['namespace' => 'Hadihosseini88\Dashboard\Http\Controllers', 'middleware' => ['web','auth','verified']], function ($router) {

    $router->get('/home', 'DashboardController@home')->name('home');
});
