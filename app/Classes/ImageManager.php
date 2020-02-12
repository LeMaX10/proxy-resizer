<?php


namespace App\Classes;

use App\Application;
use App\Classes\Contracts\ExternalFile as ExternalFileContract;
use App\Classes\Contracts\File;
use App\Classes\Entity\ExternalFile;
use App\Exceptions\QueryParamNotFoundException;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class ImageManager
 * @package App\Classes
 */
class ImageManager
{
    /**
     * @var Application
     */
    protected $app;

    /** @var Request */
    protected $request;

    /**
     * @var array
     */
    protected $queryParams;

    /**
     * @var ExternalFileContract
     */
    protected $externalFile;

    /**
     * ImageManager constructor.
     * @param Application $app
     * @param Request $request
     * @throws \Exception
     */
    public function __construct(Application $app, Request $request)
    {
        $this->app         = $app;
        $this->request     = $request;
        $this->queryParams = $this->request->getQueryParams();

        $this->parseImageUrl();
    }

    /**
     * @throws \Exception
     */
    public function parseImageUrl()
    {
        if (! array_key_exists('image', $this->queryParams)) {
            throw new QueryParamNotFoundException('image');
        }

        $this->externalFile = new ExternalFile($this->queryParams['image']);
    }

    /**
     * @return Contracts\File|Entity\File
     * @throws \App\Exceptions\ExtensionNotAllowedException
     */
    public function convert(): File
    {
        $imageConverter = new ImageConverter($this->app, $this->externalFile, $this->queryParams);
        return $imageConverter->run();
    }
}
