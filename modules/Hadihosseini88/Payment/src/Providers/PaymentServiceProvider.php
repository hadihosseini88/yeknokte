<?php

namespace Hadihosseini88\Payment\Providers;

use Hadihosseini88\Payment\Gateways\Gateway;
use Hadihosseini88\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Hadihosseini88\Payment\Models\Payment;
use Hadihosseini88\Payment\Models\Settlement;
use Hadihosseini88\Payment\Policies\PaymentPolicy;
use Hadihosseini88\Payment\Policies\SettlementPolicy;
use Hadihosseini88\Payment\Providers\EventServiceProvider;
use Hadihosseini88\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class PaymentServiceProvider extends ServiceProvider
{
    public $namespace = 'Hadihosseini88\Payment\Http\Controllers';
    public function register()
    {
        $this->app->register(EventServiceProvider::class);

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Payment');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang');
        Route::middleware('web')->namespace($this->namespace)->group(__DIR__.'/../Routes/payment_routes.php');
        Route::middleware('web')->namespace($this->namespace)->group(__DIR__.'/../Routes/settlement_routes.php');
//        Gate::policy(Payment::class,PaymentPolicy::class);
        Gate::policy(Settlement::class,SettlementPolicy::class);
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

        config()->set('sidebar.items.my-purchases', [
            "icon" => "i-my__purchases",
            "title" => "خریدهای من",
            "url" => route('purchases.index'),

        ]);

        config()->set('sidebar.items.settlements', [
            "icon" => "i-checkouts",
            "title" => "تسویه حساب ها",
            "url" => route('settlements.index'),
            "permission"=>[
                Permission::PERMISSION_TEACH,
                Permission::PERMISSION_MANAGE_SETTLEMENTS
            ],
        ]);

        config()->set('sidebar.items.settlementsCreate', [
            "icon" => "i-checkout__request",
            "title" => "درخواست تسویه",
            "url" => route('settlements.create'),
            "permission"=>[
                Permission::PERMISSION_TEACH,
            ],
        ]);
    }
}
