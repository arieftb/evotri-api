<?php

namespace App\Providers;

use Illuminate\Support\Collection;
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
        //
    }

    public function boot()
    {
        // TODO : IMPROVE THIS
        Collection::macro('isVisibleEvent', function() {
            return collect($this)->filter(function ($event) {
                return $event->is_admin == 1 || $event->is_joined == 1 || $event->is_public == 1;
            });
        });
    }
}
