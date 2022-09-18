<?php

namespace Hadihosseini88\Course\Providers;

use Hadihosseini88\Course\Database\Seeds\RolePermissionTableSeeder;
use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Course\Policies\CoursePolicy;
use Hadihosseini88\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class CourseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/courses_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Courses');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', "Courses");
        \DatabaseSeeder::$seeders[] = RolePermissionTableSeeder::class;
        Gate::policy(Course::class,CoursePolicy::class);

    }

    public function boot()
    {
        config()->set('sidebar.items.courses', [
            "icon" => "i-courses",
            "title" => "دوره ها",
            "url" => route('courses.index')
        ]);
    }

}
