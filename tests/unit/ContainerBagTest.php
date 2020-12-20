<?php


namespace Tests\Unit;


use DI\DependencyInjection\ContainerBag;
use PHPUnit\Framework\TestCase;

class ContainerBagTest extends TestCase
{
    private $containerBag;

    public function setUp(): void
    {
        $this->containerBag = new ContainerBag();
    }

    public function testSet(){
        $this->assertNotNull($this->containerBag[\stdClass::class] = new \stdClass());
    }
}
