<?php


namespace App\Exceptions;


use Throwable;

/**
 * Class ExtensionNotAllowedException
 * @package App\Exceptions
 */
class ExtensionNotAllowedException extends \Exception
{
    /**
     * @var string
     */
    protected $param;

    /**
     * ExtensionNotAllowedException constructor.
     * @param string $param
     */
    public function __construct(string $param)
    {
        $this->param = $param;

        $this->message = sprintf('Extension %s not in whitelist', $param);
    }
}
