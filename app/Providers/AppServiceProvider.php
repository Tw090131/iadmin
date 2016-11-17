<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //一般用这种方式
        view()->composer(
            'layouts.sidebar', 'App\Http\ViewComposers\MenuComposer'//第一个参数指定模版  * 是说有页面,第一个参数可以用数组
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
