<?php


namespace App\Classes\Strategies;


use App\Application;
use App\Classes\Contracts\File;

/**
 * Class Strategy
 * @package App\Classes\Strategies
 */
abstract class Strategy
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var File
     */
    protected $file;

    /**
     * Strategy constructor.
     * @param App $app
     * @param array $options
     * @param File $file
     */
    public function __construct(Application $app, array $options, File $file)
    {
        $this->app = $app;
        $this->options = $options;
        $this->file = $file;
    }

    /**
     * @param string $dirPath
     */
    protected function allowDir(string $dirPath): void
    {
        if(!is_readable($dirPath)) {
            mkdir($dirPath);
        }
    }
}
