<?php


namespace App\Classes\Strategies;


use App\Classes\Contracts\ConverterStrategy;
use App\Classes\Contracts\File as FileContract;
use App\Classes\Entity\File;
use Gumlet\ImageResize;

/**
 * Class ResizeOrCropStrategy
 * @package App\Classes\Strategies
 */
class ResizeOrCropStrategy extends Strategy implements ConverterStrategy
{

    /**
     * @inheritDoc
     */
    public function run(): FileContract
    {
        if (!isset($this->options['width']) && !isset($this->options['height'])) {
            throw new \Exception('Not resize image');
        }

        $domainDir = $this->app->storage('app/resize/'. $this->file->getExternalFile()->getDomain());
        $this->allowDir($domainDir);

        $resizeFilePath = $domainDir .'/'. $this->getResizeFileName();
        if (file_exists($resizeFilePath)) {
            return new File($resizeFilePath, $this->file->getExternalFile());
        }

        switch($this->options['mode']) {
            case 'resize':
                return $this->resizeMode($resizeFilePath);
                break;
            case 'crop':
                return $this->cropMode($resizeFilePath);
                break;
            default:
                throw new \Exception('Mode is not allowed');
        }
    }

    /**
     * @param string $destination
     * @return FileContract
     * @throws \Gumlet\ImageResizeException
     */
    protected function resizeMode(string $destination): FileContract
    {
        $imageResize = new ImageResize($this->file->getPath());
        if ($this->getWidth() > 0 && $this->getWidth() > 0) {
            $imageResize->resize($this->getWidth(), $this->getWidth());
        } else if($this->getWidth() > 0) {
            $imageResize->resizeToWidth($this->getWidth());
        } else if($this->getWidth() > 0) {
            $imageResize->resizeToHeight($this->getWidth());
        }

        $imageResize->save($destination);
        return new File($destination, $this->file->getExternalFile());
    }

    /**
     * @param string $destination
     * @return FileContract
     * @throws \Gumlet\ImageResizeException
     */
    public function cropMode(string $destination): FileContract
    {
        $imageResize = new ImageResize($this->file->getPath());
        $imageResize->crop($this->getWidth(), $this->getHeight());

        $imageResize->save($destination);
        return new File($destination, $this->file->getExternalFile());
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return (int) $this->options['width']  ?? 0;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return (int) $this->options['height'] ?? 0;
    }

    /**
     * @return string
     */
    public function getResizeFileName(): string
    {
        return $this->file->getFilename() .'-'. $this->getWidth() .'x'. $this->getHeight() .'.'. $this->file->getExtension();
    }
}
