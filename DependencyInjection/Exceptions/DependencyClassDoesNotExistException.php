<?php


namespace DI\DependencyInjection\Exceptions;


use Psr\Container\ContainerExceptionInterface;

class DependencyClassDoesNotExistException extends \Exception implements ContainerExceptionInterface{
    public function __construct($dependency, $code = 0, \Exception $previous = null)
    {
        $message = "{$dependency} does not exist";
        parent::__construct($message, $code, $previous);
    }
}