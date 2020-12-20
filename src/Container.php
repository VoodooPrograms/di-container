<?php


namespace DI\DependencyInjection;


use DI\DependencyInjection\Exceptions\DependencyClassDoesNotExistException;
use DI\DependencyInjection\Exceptions\DependencyHasNoDefaultValueException;
use DI\DependencyInjection\Exceptions\DependencyIsNotInstantiableException;
use DI\DependencyInjection\Exceptions\DependencyNotRegisteredException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/*
 * PSR - 11
 */
class Container implements ContainerInterface
{
    protected $services = [];

    public function __construct()
    {

    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param $entry
     * @return mixed Entry.
     * @throws DependencyIsNotInstantiableException
     * @throws DependencyNotRegisteredException
     */
    public function get($entry)
    {
        if (!$this->has($entry)){
            throw new DependencyNotRegisteredException($entry);
        }

        $service = $this->services[$entry];
        if (is_callable($service)) return $service;
        return $this->specifies($service);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param $entry
     * @return bool
     */
    public function has($entry)
    {
        return isset($this->services[$entry]);
    }


    /**
     * This method checks if key in $services should be abstract or specific
     *
     * @param $abstract
     * @param null $specific
     */
    public function set($abstract, $specific = null){
        if ($specific === null){
            $specific = $abstract;
        }
        $this->services[$abstract] = $specific;
    }

    public function unset($entry){
        unset($this->services[$entry]);
    }

    /**
     * @param string $entry
     * @return object
     * @throws DependencyClassDoesNotExistException
     * @throws DependencyHasNoDefaultValueException
     * @throws DependencyIsNotInstantiableException
     */
    public function specifies(string $entry){
        $resolved = [];
        $reflection = $this->getReflection($entry);
        $constructor = null;
        $parameters = [];
        if ($reflection->isInstantiable()) {
            $constructor = $reflection->getConstructor();
            if (!is_null($constructor)){
                $parameters = $constructor->getParameters();
            }
        } else {
            throw new DependencyIsNotInstantiableException($entry);
        }
        if (is_null($constructor) || empty($parameters)){
            return $reflection->newInstance();
        }

        foreach ($parameters as $parameter){
            $resolved[] = $this->resolveParameter($parameter);
        }
        return $reflection->newInstanceArgs($resolved); // return new instance with resolved dependencies
    }

    public function resolveParameter(\ReflectionParameter $parameter)
    {
        if ($parameter->getClass() !== null) { // The parameter is a class
            $typeName = $parameter->getType()->getName();
            if ($this->isUserDefined($parameter)) {
                $this->set($typeName); // Register service
            }
            return $this->get($typeName);
        } else { // The parameter is a string, int, float or bool

            if ($parameter->isDefaultValueAvailable()) { // Check if default value for a parameter is set

                return $parameter->getDefaultValue(); // Get default value of parameter
            } else {
                throw new DependencyHasNoDefaultValueException($parameter->name);
            }
        }
    }

    public function getReflection(string $entry)
    {
        try {
            $reflection = new \ReflectionClass($entry);

            // Check if class is instantiable
            if (!$reflection->isInstantiable()) {
                throw new DependencyIsNotInstantiableException($entry);
            }

            return $reflection;
        } catch (\ReflectionException $ex) {
            throw new DependencyClassDoesNotExistException($entry);
        }
    }

    public function isUserDefined(\ReflectionParameter $parameter)
    {
        // check if parameter is part of SPL
        if ($parameter->getType()->isBuiltin()) {
            return false;
        }
        $class = $parameter->getClass();
        $isUserDefined = $class->isUserDefined(); //isInternal()
        return $isUserDefined;
    }
}