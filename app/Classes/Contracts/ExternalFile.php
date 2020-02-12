<?php


namespace App\Classes\Contracts;


interface ExternalFile
{
    /**
     * @return string
     */
    public function getUrl(): string;

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
    public function getDomain(): string;
}
