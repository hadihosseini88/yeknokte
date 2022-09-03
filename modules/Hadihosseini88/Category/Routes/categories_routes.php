<?php

Route::group(['namespace' => 'Hadihosseini88\Category\Http\Controllers', 'middleware' => ['web','auth','verified']],function ($router){
    $router->resource('categories','CategoryController');
});


