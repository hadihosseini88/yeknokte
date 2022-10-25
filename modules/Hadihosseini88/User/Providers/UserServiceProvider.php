<?php

namespace Hadihosseini88\User\Providers;

use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\User\Database\Seeds\UsersTableSeeder;
use Hadihosseini88\User\Http\Middleware\StoreUserIp;
use Hadihosseini88\User\Models\User;
use Hadihosseini88\User\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;


class UserServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/user_routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadFactoriesFrom(__DIR__ . '/../Database/Factories');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'User');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', "User");
        $this->app['router']->pushMiddlewareToGroup('web', StoreUserIp::class);

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'Hadihosseini88\User\Database\Factories\\' . class_basename($modelName) . 'Factory';
        });
        \DatabaseSeeder::$seeders[] = UsersTableSeeder::class;

        config()->set('auth.providers.users.model', User::class);

        Gate::policy(User::class, UserPolicy::class);
    }

    public function boot()
    {
        config()->set('sidebar.items.users', [
            "icon" => "i-users",
            "title" => "کاربران",
            "url" => route('users.index'),
            "permission" => Permission::PERMISSION_MANAGE_USERS,
        ]);

        config()->set('sidebar.items.userInformation', [
            "icon" => "i-user__inforamtion",
            "title" => "اطلاعات کاربری",
            "url" => route('users.profile')
        ]);

    }
}
