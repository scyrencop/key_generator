<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        Blade::directive('message_type', function($type_id) {
            return "<input id=\"message_type\" type=\"hidden\" name=\"type_id\" value=\"{$type_id}\">";
        });

        
        Blade::directive('label', function($type_id) {
            return "<input id=\"message_type\" type=\"hidden\" name=\"type_id\" value=\"{$type_id}\">";
        });
        
        // {{ trans('placeholder.title_article') }}
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
