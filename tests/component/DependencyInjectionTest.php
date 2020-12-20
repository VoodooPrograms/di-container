<?php


namespace Owd\Skeleton\Tests\Component;


use DI\DependencyInjection\Container;
use DI\DependencyInjection\Exceptions\DependencyIsNotInstantiableException;
use DI\DependencyInjection\Exceptions\DependencyNotRegisteredException;
use PHPUnit\Framework\TestCase;
use Services\Service1\Profiler;
use Services\Service2\AbstractService;
use Services\Service2\Service;

class DependencyInjectionTest extends TestCase
{
    private Container $container;

    public function setUp(): void
    {
        $this->container = new Container();
    }

    public function testDefineAndRetrieveService() {
        $this->container->set(Profiler::class);
        $this->assertNotNull($this->container->get(Profiler::class));
        $this->assertInstanceOf(Profiler::class, $this->container->get(Profiler::class));
    }

    public function testDefineAndRetrieveServiceAsClosure() {
        $this->container->set('service', function() {
            return new \stdClass();
        });
        $this->assertNotNull($this->container->get('service'));
        $this->assertInstanceOf(\Closure::class, $this->container->get('service'));
    }

    public function testDefineAndRetrievePolymorphicService() {
        $this->container->set(AbstractService::class, Service::class);
        $this->assertNotNull($this->container->get(AbstractService::class));
        $this->assertInstanceOf(AbstractService::class, $this->container->get(AbstractService::class));
        $this->assertInstanceOf(Service::class, $this->container->get(AbstractService::class));
    }

    public function testDefineNotInstantiableService() {
        $this->container->set(AbstractService::class);
        $this->expectException(DependencyIsNotInstantiableException::class);
        $this->container->get(AbstractService::class);
    }

    public function testAccessingNotRegisteredService() {
        $this->expectException(DependencyNotRegisteredException::class);
        $this->container->get(AbstractService::class);
    }
}
