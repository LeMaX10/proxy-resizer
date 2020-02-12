<?php namespace App\Http;

use App\Application;
use App\Classes\ImageManager;
use GuzzleHttp\Psr7\LazyOpenStream;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class ImageController
 * @package App\Http
 */
class ImageController
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * ImageController constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     *
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $imageManager = new ImageManager($this->app, $request);
        $image = $imageManager->convert();

        return $response->withBody(new LazyOpenStream($image->getPath(), 'r'))
                        ->withHeader("Content-type",   $image->getMimeType())
                        ->withHeader("Content-length", $image->getFilesize())
                        ->withHeader("Cache-control", 'max-age=' . (60*60*24*365))
                        ->withHeader("Expires", gmdate(DATE_RFC1123, time()+60*60*24*365));
    }
}
