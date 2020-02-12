<?php


namespace App\Classes\Strategies;


use App\Classes\Contracts\ConverterStrategy;
use App\Classes\Contracts\File as FileContract;
use App\Classes\Entity\File;
use WebPConvert\WebPConvert;

/**
 * Class ConvertToWebpStrategy
 * @package App\Classes\Strategies
 */
class ConvertToWebpStrategy extends Strategy implements ConverterStrategy
{
    /**
     * @inheritDoc
     */
    public function run(): FileContract
    {
        try {
            $domainDir = $this->app->storage('app/webp/' . $this->file->getExternalFile()->getDomain());
            $this->allowDir($domainDir);

            $webpPath = $domainDir .'/'. $this->file->getFilename() . '.webp';
            if (!file_exists($webpPath)) {
                WebPConvert::convert($this->file->getPath(), $webpPath, []);
            }

            return new File($webpPath, $this->file->getExternalFile());
        } catch(\Exception $e) {
            return $this->file;
        }
    }
}
