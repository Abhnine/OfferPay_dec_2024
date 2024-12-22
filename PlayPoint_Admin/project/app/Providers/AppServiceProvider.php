<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\settings;
use App\Models\Admin;

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
        $setting_data = settings::where('id', '=', 1)->first();
        View::share('setting_data', $setting_data);

        $admin_data = Admin::where('id', '=', 1)->first();
        View::share('admin_data', $admin_data);
    }
}
