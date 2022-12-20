<?php

namespace Hadihosseini88\Common\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    private $namespace ='Hadihosseini88\Common\Http\Controllers';
    public function register()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/routes.php');
        $this->loadViewsFrom(__DIR__ . "/../Resources", 'Common');
    }

    public function boot()
    {
    }

}
