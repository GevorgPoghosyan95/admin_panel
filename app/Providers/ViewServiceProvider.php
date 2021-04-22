<?php

namespace App\Providers;

use App\Managers\SidebarManager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $sidebar_manager = new SidebarManager();
        $groups = $sidebar_manager->groups();
        $sidebar = generate_sidebar_groups($groups,$output=null);
        View::composer('layout.sidebar', function($view) use($sidebar) {
            $view->with(['sidebar' => $sidebar]);
        });
    }
}
