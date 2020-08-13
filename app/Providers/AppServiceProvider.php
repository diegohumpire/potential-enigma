<?php

namespace App\Providers;

use Enigma\Auth\Domain\Repositories\UserRepository;
use Enigma\Auth\Infraestructure\Eloquent\UserEloquentRepository;
use Enigma\Catalog\Domain\Repositories\ProductRepository;
use Enigma\Catalog\Domain\Repositories\SupplierRepository;
use Enigma\Catalog\Infraestructure\ProductEloquentRepository;
use Enigma\Catalog\Infraestructure\SupplierEloquentRepository;
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
        $this->app->singleton(UserRepository::class, function ($app) {
            return new UserEloquentRepository();
        });

        $this->app->singleton(ProductRepository::class, function () {
            return new ProductEloquentRepository();
        });

        $this->app->singleton(SupplierRepository::class, function () {
            return new SupplierEloquentRepository();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
