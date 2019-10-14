<?php

namespace App\Providers;

use Goutte;
use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Media;
use App\Models\Article;
use App\Models\Project;
use App\Models\Category;
use App\Models\Coordinate;
use Illuminate\Support\Facades\View;
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
