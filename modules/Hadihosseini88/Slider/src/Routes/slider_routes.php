<?php

Route::group(['middleware'=>['auth']],function (\Illuminate\Routing\Router $router){
    $router->resource('slides', 'SlideController');
});
