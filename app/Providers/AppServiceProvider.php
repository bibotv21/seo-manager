<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $servicesBindings = [
        'App\Services\Interfaces\TextLinkServiceInterface' => 'App\Services\TextLinkService',
        'App\Services\Interfaces\WebsiteServiceInterface' => 'App\Services\WebsiteService',
        'App\Services\Interfaces\HeperService' => 'App\Services\HelperService'
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach($this->servicesBindings as $key => $val){
            $this->app->bind($key, $val);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
