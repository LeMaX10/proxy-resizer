<?php namespace App\Classes;


use App\Application;
use App\Classes\Contracts\ExternalFile;
use App\Classes\Contracts\File as FileContract;
use App\Classes\Entity\File;
use App\Classes\Strategies\ConvertToWebpStrategy;
use App\Classes\Strategies\DownloadOriginalStrategy;
use App\Classes\Strategies\OptimizeStrategy;
use App\Classes\Strategies\ResizeOrCropStrategy;
use App\Exceptions\ExtensionNotAllowedException;

/**
 * Class ImageConverter
 * @package App\Classes
 */
class ImageConverter
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var ExternalFile
     */
    protected $externalFile;

    /**
     * @var array
     */
    protected $strategies = [];

    /**
     * @var File
     */
    protected $file;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $allowedOptions = [
        'mode',
        'width',
        'height',
        'webp',
        'optimize'
    ];

    /**
     * ImageConverter constructor.
     * @param Application $app
     * @param ExternalFile $externalFile
     *
     * @param array $options
     * @throws ExtensionNotAllowedException
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __construct(Application $app, ExternalFile $externalFile, array $options = [])
    {
        $this->app          = $app;
        $this->externalFile = $externalFile;
        $this->options      = $this->parseOptions($options);

        if (! $this->isAllowExtension()) {
            throw new ExtensionNotAllowedException($this->externalFile->getExtension());
        }
    }

    /**
     * @param array $options
     * @return array
     */
    protected function parseOptions(array $options): array
    {
        $parseOptions = [];
        foreach($options as $key => $value) {
            if(!in_array($key, $this->allowedOptions, true)) {
                continue;
            }

            $parseOptions[$key] = $value;
        }

        return $parseOptions;
    }

    /**
     * @return bool
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    protected function isAllowExtension(): bool
    {
        return in_array($this->externalFile->getExtension(), $this->app->config('security.extension'), true);
    }

    /**
     * @return File
     */
    public function run(): FileContract
    {
        $this->file = $this->getFile();

        if(array_key_exists('mode', $this->options) && in_array($this->options['mode'], ['crop', 'resize'], true)) {
            $this->strategies[] = ResizeOrCropStrategy::class;
        }

        if(array_key_exists('webp', $this->options)) {
            $this->strategies[] = ConvertToWebpStrategy::class;
        }

        if(array_key_exists('optimize', $this->options)) {
            $this->strategies[] = OptimizeStrategy::class;
        }

        return $this->runContext();
    }

    /**
     * @return File
     */
    protected function runContext(): FileContract
    {
        foreach($this->strategies as $strategyClass) {
            $strategy = new $strategyClass($this->app, $this->options, $this->file);
            $this->file = $strategy->run();
        }

        return $this->file;
    }

    /**
     * @return FileContract
     */
    protected function getFile(): FileContract
    {
        $hashFileName = md5($this->externalFile->getFilename()) .'.'. $this->externalFile->getExtension();
        $filePath = $this->app->storage('app/original/'. $this->externalFile->getDomain() .'/'. $hashFileName);

        if (!file_exists($filePath)) {
            $this->strategies[] = DownloadOriginalStrategy::class;
        }

        return new File($filePath, $this->externalFile);
    }
}
