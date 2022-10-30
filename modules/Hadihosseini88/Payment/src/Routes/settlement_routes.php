<?php
Route::group(['middleware'=>'auth'], function ($router) {
    $router->get('settlements/create','SettlementController@create')->name('settlements.create');
    $router->post('settlements','SettlementController@store')->name('settlements.store');
});
