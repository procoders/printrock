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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        try {
            if ( class_exists( 'Darkaonline\L5Swagger\L5SwaggerServiceProvider' ) ) {
                $this->app->register('Darkaonline\L5Swagger\L5SwaggerServiceProvider');
            }
        } catch (Exception $e) {

        }
    }
}
