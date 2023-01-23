<?php

namespace App\Providers;

use App\Models\Course;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Observers\CourseObserver;

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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
