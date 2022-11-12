<?php

namespace Hadihosseini88\Discount\Providers;

use Hadihosseini88\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DiscountServiceProvider extends ServiceProvider
{
    public $namespace ='Hadihosseini88\Discount\Providers';
    public function register()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/discounts_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Discount');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

    }

    public function boot()
    {
        config()->set('sidebar.items.discounts',[
            "icon"=>"i-discounts",
            "title"=>"تخفیف ها",
            "url"=> route('discounts.index'),
            "permission" => Permission::PERMISSION_MANAGE_DISCOUNTS,
        ]);
    }
}
