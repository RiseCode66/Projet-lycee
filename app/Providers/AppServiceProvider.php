<?php

namespace App\Providers;

use App\Models\page;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer(['base.base','component.Page'], function ($view) {
        $currency = page::all();
        $view->with('currency', $currency);
        });
        Paginator::useBootstrapFive();
    }
}
