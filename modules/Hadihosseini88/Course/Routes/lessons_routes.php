<?php

Route::group(['namespace' => 'Hadihosseini88\Course\Http\Controllers', 'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->get('courses/{course}/lessons/create','LessonController@create')->name('lessons.create');
    $router->post('courses/{course}/lessons','LessonController@store')->name('lessons.store');
});
