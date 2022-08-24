<?php

Route::group([
    'namespace' => 'Hadihosseini88\User\Http\Controllers',
    'middleware' => 'web'
], function ($router) {
    Auth::routes(['verify' => true]);
});
