<?php


namespace App\Classes\Contracts;


/**
 * Interface File
 * @package App\Classes\Contracts
 */
interface File
{
    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string
     */
    public function getFilename(): string;
    /**
     * @return string
     */
    public function getExtension(): string;

    /**
     * @return string
     */
    public function getMimeType(): string;

    /**
     * @return \App\Classes\Contracts\ExternalFile
     */
    public function getExternalFile(): \App\Classes\Contracts\ExternalFile;
}
