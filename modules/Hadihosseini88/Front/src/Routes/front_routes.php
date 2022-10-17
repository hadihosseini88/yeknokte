<?php

Route::group(['middleware' => ['web'], 'namespace' => 'Hadihosseini88\Front\Http\Controllers'],
    function ($router) {
        $router->get('/', 'FrontController@index');
//        $router->get('/c-{slug}', 'FrontController@singleCourse')->name('singleCourse');
//        $router->get('/tutors/{username}', 'FrontController@singleTutor')->name('singleTutor');
    });
