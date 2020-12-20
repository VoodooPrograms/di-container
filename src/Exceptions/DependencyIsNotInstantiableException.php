<?php


namespace DI\DependencyInjection\Exceptions;


use Psr\Container\ContainerExceptionInterface;
use Throwable;

class DependencyIsNotInstantiableException extends \Exception implements ContainerExceptionInterface
{
    public function __construct(string $id, int $code = 0, Throwable $previous = null)
    {
        $message = "Dependency $id is not instantiable";
        parent::__construct($message, $code, $previous);
    }
}