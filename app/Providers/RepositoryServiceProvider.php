<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // 单例 (服务模式)
         $this->app->singleton('App\Repositories\Contracts\UserInterface', function ($app) {
             return new \App\Repositories\Eloquent\UserServiceRepository();
         });

        // 单例 (门面模式)
        $this->app->singleton('UserFacadeRepository', function ($app) {//实现类名称
            return new \App\Repositories\Eloquent\UserFacadeRepository();//反回实现类的实例
        });

        // 绑定
      //  $this->app->bind('App\Repositories\Contracts\UserInterface', 'App\Repositories\Eloquent\UserServiceRepository');
    }
}
