<?php

namespace Hadihosseini88\Payment\Providers;

use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Payment\Gateways\Gateway;
use Hadihosseini88\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Hadihosseini88\Payment\Models\Payment;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public $namespace = 'Hadihosseini88\Payment\Http\Controllers';
    public function register()
    {

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::middleware('web')->namespace($this->namespace)->group(__DIR__.'/../Routes/payment_routes.php');
    }

    public function boot()
    {
        $this->app->singleton(Gateway::class,function ($app){
            return new ZarinpalAdaptor();
        });

//        Course::resolveRelationUsing('payments',function ($courseModel) {
//            return $courseModel->morphMany(Payment::class,'paymentable');
//        });
    }
}
