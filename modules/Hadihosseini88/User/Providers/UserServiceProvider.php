<?php

namespace Hadihosseini88\User\Providers;

use Hadihosseini88\User\Models\User;
use Hadihosseini88\User\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{

    public function register()
    {
        config()->set('auth.providers.users.model',User::class);
        Gate::policy(User::class,UserPolicy::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/user_routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadFactoriesFrom(__DIR__ . '/../Database/Factories');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'User');

        config()->set('sidebar.items.users',[
            "icon"=>"i-users",
            "title"=>"کاربران",
            "url"=> route('users.index')
        ]);

    }
}
