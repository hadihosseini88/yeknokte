<?php

namespace Hadihosseini88\Ticket\Providers;

use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\Ticket\Models\Reply;
use Hadihosseini88\Ticket\Models\Ticket;
use Hadihosseini88\Ticket\Policies\ReplyPolicy;
use Hadihosseini88\Ticket\Policies\TicketPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider
{
    public $namespace ='Hadihosseini88\Ticket\Http\Controllers';

    public function register()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Tickets');
        Gate::policy(Ticket::class,TicketPolicy::class);
        Gate::policy(Reply::class,ReplyPolicy::class);

    }

    public function boot()
    {
        config()->set('sidebar.items.tickets',[
            "icon"=>"i-tickets",
            "title"=>"تیکت ها",
            "url"=> route('tickets.index'),
        ]);
    }

}
