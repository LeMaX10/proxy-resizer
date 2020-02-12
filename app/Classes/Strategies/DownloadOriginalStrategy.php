<?php


namespace App\Classes\Strategies;


use App\Classes\Contracts\ConverterStrategy;
use App\Classes\Contracts\File;

/**
 * Class DownloadOriginalStrategy
 * @package App\Classes\Strategies
 */
class DownloadOriginalStrategy extends Strategy implements ConverterStrategy
{
    /**
     * @inheritDoc
     */
    public function run(): File
    {
        $this->allowDir(dirname($this->file->getPath()));

        file_put_contents($this->file->getPath(), file_get_contents($this->file->getExternalFile()->getUrl()));
        return $this->file;
    }
}
