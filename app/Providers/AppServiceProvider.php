<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MemberPointService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MemberPointService::class, function ($app) {
            return new MemberPointService();
        });
    }

    public function boot()
    {
        //
    }
}

