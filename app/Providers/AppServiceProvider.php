<?php

namespace App\Providers;

use App\Models\Order;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
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
        Paginator::useBootstrap();

        view()->share('app_name', config('app.name'));

        view()->composer('*', function ($view) 
        {
            $user = Auth::user();

            if ( $user && $user->hasRole('admin')) 
            {
                $view->with('order_count', Order::where('status', Order::PENDING)
                ->groupBy('pet_id')
                ->count());
            } 
            
            if ( $user && $user->hasRole('user')) 
            {
                $view->with('order_count', Order::pending()->whereBelongsTo($user)->count());
            } 
        });
            

    }
}