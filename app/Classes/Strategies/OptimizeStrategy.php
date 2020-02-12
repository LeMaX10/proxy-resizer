<?php


namespace App\Classes\Strategies;


use App\Classes\Contracts\ConverterStrategy;
use App\Classes\Contracts\File as FileContract;
use App\Classes\Entity\File;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class OptimizeStrategy extends Strategy implements ConverterStrategy
{

    /**
     * @inheritDoc
     */
    public function run(): FileContract
    {
        $domainDir = $this->app->storage('app/optimize/' . $this->file->getExternalFile()->getDomain());
        $this->allowDir($domainDir);

        $optimizePath = $domainDir .'/'. $this->file->getFilename() . '-opt.' . $this->file->getExtension();
        if (!file_exists($optimizePath)) {
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($this->file->getPath(), $optimizePath);
        }

        return new File($optimizePath, $this->file->getExternalFile());
    }
}
