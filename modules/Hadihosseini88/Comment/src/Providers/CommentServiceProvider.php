<?php
namespace Hadihosseini88\Comment\Providers;

use Hadihosseini88\Comment\Models\Comment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider
{
        public $namespace ='Hadihosseini88\Comment\Http\Controllers';

        public function register()
    {
        Route::middleware(['web','auth'])
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/comments_routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Comments');
//        Gate::policy(Comment::class,CommentPolicy::class);


    }

    public function boot()
    {
        config()->set('sidebar.items.comments',[
            "icon"=>"i-comments",
            "title"=>"نظرات",
            "url"=> route('comments.index'),
        ]);
    }

}
