<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot ()
    {
        /* 
            View::share('channels', Channel::all()); // share but will execute before the page load and the test will fail 
            instead use View::composer('*', function ($view) {}); 
        */
        view()->composer('*', function ($view)
        {
            $channels = cache()->rememberForever('channels', function () {
                return Channel::where('archived', false)->orderBy('name', 'DESC')->get();
            });
            
            $view->with('channels', $channels);
        });

        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register ()
    {
        //
    }
}
