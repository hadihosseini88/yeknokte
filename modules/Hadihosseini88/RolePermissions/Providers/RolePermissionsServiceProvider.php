<?php

namespace Hadihosseini88\RolePermissions\Providers;

use Illuminate\Support\ServiceProvider;

class RolePermissionsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/role_permissions_routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views','RolePermissions');
    }

    public function boot()
    {
        config()->set('sidebar.items.role-permissions',[
            "icon"=>"i-role-permissions",
            "title"=>"نقش های کاربران",
            "url"=> route('role-permissions.index')
        ]);
    }

}
