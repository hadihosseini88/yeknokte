<?php


namespace Hadihosseini88\Category\Providers;

use Hadihosseini88\Category\Models\Category;
use Hadihosseini88\Category\Policies\CategoryPolicy;
use Hadihosseini88\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/categories_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Categories');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        Gate::policy(Category::class,CategoryPolicy::class);

    }

    public function boot(){
        config()->set('sidebar.items.categories',[
            "icon"=>"i-categories",
            "title"=>"دسته بندی ها",
            "url"=> route('categories.index'),
            "permission" => Permission::PERMISSION_MANAGE_CATEGORIES,
        ]);
    }

}
