<?php


namespace App\Exceptions;


use Throwable;

/**
 * Class AccessDeniedDomainException
 * @package App\Exceptions
 */
class AccessDeniedDomainException extends \Exception
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

        $this->message = sprintf('Domain %s not in whitelist', $param);
    }
}
