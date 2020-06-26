<?php


namespace Tests;


use DI\DependencyInjection\Container;
use DI\DependencyInjection\Exceptions\DependencyIsNotInstantiableException;
use DI\DependencyInjection\Exceptions\DependencyNotRegisteredException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    private $container;

    public function setUp(): void
    {
        $this->container = new Container();
    }

    public function testSet(){
        $this->assertNull($this->container->set(\stdClass::class));
    }

    public function testSetAbstract(){
        $mock = $this->getMockBuilder("stdAbstractClass")->getMock();
        $abstract_mock = $this->getMockForAbstractClass(get_class($mock));

        # Edge case for abstract class
        $this->assertNull($this->container->set(get_class($abstract_mock), \stdClass::class));

        # Edge case for non abstract class
        $this->assertNull($this->container->set(get_class($mock), \stdClass::class));

    }

    public function testGet(){
        $this->container->set(\stdClass::class);
        $this->assertNotNull($this->container->get(\stdClass::class));
        $this->assertInstanceOf(\stdClass::class, $this->container->get(\stdClass::class));

        # Throw exception
        $this->expectException(DependencyNotRegisteredException::class);
        $this->container->get("classWhichDoesNotExist");

    }

    public function testDependencyIsNotInstantiableException(){
        $this->container->set(stdAbstractClass::class);

        $this->expectException(DependencyIsNotInstantiableException::class);
        $this->container->get(stdAbstractClass::class);
    }

    public function testHas(){
        $this->assertFalse($this->container->has("thisClassDoesNotExist"));

        $this->container->set(\stdClass::class);
        $this->assertTrue($this->container->has(\stdClass::class));
    }

    public function testUnset(){
        $this->container->set(\stdClass::class);
        $this->assertTrue($this->container->has(\stdClass::class));

        $this->container->unset(\stdClass::class);
        $this->assertTrue(!$this->container->has(\stdClass::class));
    }

}


abstract class stdAbstractClass{}