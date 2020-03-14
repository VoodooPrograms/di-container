<?php


namespace DI\DependencyInjection\Exceptions;


use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class DependencyNotRegisteredException extends \Exception implements NotFoundExceptionInterface
{
    public function __construct(string $id, int $code = 0, Throwable $previous = null)
    {
        $message = "Dependency $id is not registered";
        parent::__construct($message, $code, $previous);
    }

}