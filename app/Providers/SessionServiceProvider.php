<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Create the sessions directory if it doesn't exist
        if (!file_exists('/tmp/sessions')) {
            mkdir('/tmp/sessions', 0777, true);
        }

        // Create the bootstrap/cache directory if it doesn't exist
        if (!file_exists('/var/task/user/bootstrap/cache')) {
            mkdir('/var/task/user/bootstrap/cache', 0777, true);
        }
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
