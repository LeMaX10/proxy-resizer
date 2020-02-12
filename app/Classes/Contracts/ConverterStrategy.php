<?php


namespace App\Classes\Contracts;


/**
 * Interface ConverterStrategy
 * @package App\Classes\Contracts
 */
interface ConverterStrategy
{
    /**
     * @return File
     */
    public function run(): File;
}
