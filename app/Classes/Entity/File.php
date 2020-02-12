<?php


namespace App\Classes\Entity;

use App\Classes\Contracts\File as FileContract;

/**
 * Class File
 * @package App\Classes\Entity
 */
class File implements FileContract
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var \App\Classes\Contracts\ExternalFile
     */
    private $externalFile;

    /**
     * File constructor.
     * @param string $path
     * @param \App\Classes\Contracts\ExternalFile $externalFile
     */
    public function __construct(string $path, \App\Classes\Contracts\ExternalFile $externalFile)
    {
        $this->path = $path;
        $this->externalFile = $externalFile;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return (string) $this->path;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return (string) pathinfo($this->path, PATHINFO_FILENAME);
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return (string) pathinfo($this->path, PATHINFO_EXTENSION);
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return (string) 'image/'. $this->getExtension();
    }

    /**
     * @return int
     */
    public function getFilesize(): int
    {
        return (int) filesize($this->path);
    }

    /**
     * @return \App\Classes\Contracts\ExternalFile
     */
    public function getExternalFile(): \App\Classes\Contracts\ExternalFile
    {
        return $this->externalFile;
    }
}
