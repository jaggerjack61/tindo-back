<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\Order;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.secondary', function ($view) {
            $messageCount = Message::where('status','unread')->count();
            $orderCount = Order::where('status','Paid')->where('delivery_status','pending')->count();
            $count = ['message'=>$messageCount, 'order'=>$orderCount];
            $view->with('syscount', $count);
        });
    }
}
