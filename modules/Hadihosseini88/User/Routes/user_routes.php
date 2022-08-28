<?php

Route::group([
    'namespace' => 'Hadihosseini88\User\Http\Controllers',
    'middleware' => 'web'
], function ($router) {
//    Auth::routes(['verify' => true]);


    Route::post('/email/verify', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('/email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
    Route::get('/email/verify', 'Auth\VerificationController@show')->name('verification.notice');

    //login
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');

    //logout
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    //reset password
    Route::get('/password/reset', 'Auth\ForgotPasswordController@showVerifyCodeRequestForm')->name('password.request');
    Route::get('/password/reset/send', 'Auth\ForgotPasswordController@sendVerifyCodeEmail')->name('password.sendVerifyCodeEmail');

    Route::get('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

    //register
    Route::post('/register', 'Auth\RegisterController@register');
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
});
