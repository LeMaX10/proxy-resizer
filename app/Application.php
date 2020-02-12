<?php namespace App;

use App\Http\ImageController;
use Noodlehaus\Config;
use DI\ContainerBuilder;
use DI\Container;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

/**
 * Class Application
 * @package App
 */
class Application
{
    /**
     * @var string
     */
    private $rootPath;

    /**
     * @var array
     */
    private $provides = [];

    /**
     * @var \Slim\App
     */
    private $app;

    /**
     * Application constructor.
     * @param string $rootPath
     * @throws \Exception
     */
    public function __construct(string $rootPath)
    {
        $containerBuilder = new ContainerBuilder;
        $containerBuilder->addDefinitions([
            ImageController::class => function (ContainerInterface $container): ImageController {
                return new ImageController($this);
            }
        ]);

        AppFactory::setContainer($containerBuilder->build());

        $this->app = AppFactory::create();
        $this->rootPath = $rootPath;

        $this->app->getContainer()->set('Config', new Config($this->rootPath .'/config'));
        $this->loadingServiceProviders();
    }

    /**
     * @return ContainerInterface
     */
    public function container()
    {
        return $this->app->getContainer();
    }

    /**
     * @param string $key
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function config(string $key)
    {
        return $this->container()->get('Config')->get($key);
    }

    /**
     *
     */
    public function loadingServiceProviders()
    {
        foreach($this->config('app.providers') as $serviceProvider) {
            if (isset($this->provides[$serviceProvider])) {
                continue;
            }

            $this->provides[$serviceProvider] = new $serviceProvider($this);
            $this->provides[$serviceProvider]->register();
        }
    }

    /**
     *
     */
    public function bootingServiceProviders()
    {
        foreach($this->provides as $providerName => $serviceProvider) {
            $serviceProvider->boot();
        }
    }

    /**
     *
     */
    public function run()
    {
        $this->bootingServiceProviders();

        $this->app->run();
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function storage(string $path)
    {
        return $this->rootPath .'/storage/' . $path;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->app, $name)) {
            return call_user_func([$this->app, $name], ...$arguments);
        }
    }
}
