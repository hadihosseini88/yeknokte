<?php
namespace Hadihosseini88\Slider\Providers;

use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\Slider\Models\Slide;
use Hadihosseini88\Slider\Policies\SlidePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SliderServiceProvider extends ServiceProvider
{
    public $namespace ='Hadihosseini88\Slider\Http\Controllers';
    public function register()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/slider_routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Slider');
        Gate::policy(Slide::class,SlidePolicy::class);
    }

    public function boot()
    {
        config()->set('sidebar.items.slider',[
            "icon"=>"i-slideshow",
            "title"=>"اسلاید ها",
            "url"=> route('slides.index'),
            "permission" => [
                Permission::PERMISSION_MANAGE_SLIDES,
            ]
        ]);
    }

}
