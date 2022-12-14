<?php

namespace Hadihosseini88\Course\Providers;

use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Course\Models\Lesson;
use Hadihosseini88\Course\Models\Season;
use Hadihosseini88\Course\Policies\CoursePolicy;
use Hadihosseini88\Course\Policies\LessonPolicy;
use Hadihosseini88\Course\Policies\SeasonPolicy;
use Hadihosseini88\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class CourseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->loadRoutesFrom(__DIR__ . '/../Routes/courses_routes.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/seasons_routes.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/lessons_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Courses');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', "Courses");

        Gate::policy(Course::class,CoursePolicy::class);
        Gate::policy(Season::class,SeasonPolicy::class);
        Gate::policy(Lesson::class,LessonPolicy::class);

    }

    public function boot()
    {
        config()->set('sidebar.items.courses', [
            "icon" => "i-courses",
            "title" => "دوره ها",
            "url" => route('courses.index'),
            "permission"=>[
                Permission::PERMISSION_MANAGE_COURSES,
                Permission::PERMISSION_MANAGE_OWN_COURSES
            ],
        ]);
    }

}
