<?php

namespace App\Providers;

use App\Layout;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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

        $header_data = Layout::where('name','header')->first();
        $footer_data = Layout::where('name','footer')->first();
        View::share(['header_data' => $header_data,'footer_data' => $footer_data]);

        Schema::defaultStringLength(191);
    }
}
