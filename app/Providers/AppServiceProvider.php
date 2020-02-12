<?php


namespace App\Providers;


use App\Http\ImageController;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Routes
        $this->app->get('/', ImageController::class);
    }
}
