<?php

Route::group(['namespace' => 'Hadihosseini88\Course\Http\Controllers', 'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->resource('courses', 'CourseController');
});
