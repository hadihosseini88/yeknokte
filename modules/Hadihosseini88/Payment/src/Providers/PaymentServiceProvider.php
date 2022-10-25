<?php

namespace Hadihosseini88\Payment\Providers;

use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Payment\Gateways\Gateway;
use Hadihosseini88\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Hadihosseini88\Payment\Models\Payment;
use Hadihosseini88\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public $namespace = 'Hadihosseini88\Payment\Http\Controllers';
    public function register()
    {

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Payment');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang');
        Route::middleware('web')->namespace($this->namespace)->group(__DIR__.'/../Routes/payment_routes.php');
    }

    public function boot()
    {
        $this->app->singleton(Gateway::class,function ($app){
            return new ZarinpalAdaptor();
        });
        config()->set('sidebar.items.payments', [
            "icon" => "i-transactions",
            "title" => "تراکنش ها",
            "url" => route('payments.index'),
            "permission"=>[
                Permission::PERMISSION_MANAGE_PAYMENTS
            ],
        ]);
    }
}
