<?php


namespace App\Exceptions;


use Throwable;

/**
 * Class QueryParamNotFound
 * @package App\Exceptions
 */
class QueryParamNotFoundException extends \Exception
{
    /**
     * @var string
     */
    protected $param;

    /**
     * QueryParamNotFound constructor.
     * @param string $param
     */
    public function __construct(string $param)
    {
        $this->param = $param;

        $this->message = sprintf('Query params %s not found', $param);
    }
}
