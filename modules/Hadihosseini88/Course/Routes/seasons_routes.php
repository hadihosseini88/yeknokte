<?php

Route::group(['namespace' => 'Hadihosseini88\Course\Http\Controllers', 'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->patch('seasons/{season}/accept','SeasonController@accept')->name('seasons.accept');
    $router->patch('seasons/{season}/reject','SeasonController@reject')->name('seasons.reject');
    $router->post('seasons/{course}','SeasonController@store')->name('seasons.store');
});
