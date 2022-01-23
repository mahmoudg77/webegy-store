<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use  Illuminate\Support\Facades\Schema; // At the top of your file

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
        Schema::defaultStringLength(191);
       // Schema::defaultStrinLocate('utf8_unicode_ci');
         config(['translatable.locales' => \App\Models\Language::Current()->pluck('code')->toArray() ]);
  

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
