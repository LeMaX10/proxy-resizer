<?php


namespace App\Providers;


use App\Application;

/**
 * Class ServiceProvider
 * @package App\Providers
 */
abstract class ServiceProvider
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * ServiceProvider constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     *
     */
    public function register()
    {

    }

    /**
     *
     */
    public function boot()
    {

    }
}
