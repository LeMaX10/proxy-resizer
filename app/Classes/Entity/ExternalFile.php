<?php


namespace App\Classes\Entity;

use App\Classes\Contracts\ExternalFile as ExternalFileContract;

/**
 * Class File
 * @package App\Classes\Entity
 */
class ExternalFile implements ExternalFileContract
{
    /**
     * @var string
     */
    private $url;

    /**
     * File constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return (string) $this->url;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return (string) pathinfo($this->url, PATHINFO_FILENAME);
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return (string) pathinfo($this->url, PATHINFO_EXTENSION);
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return (string) parse_url($this->url, PHP_URL_HOST);
    }
}
