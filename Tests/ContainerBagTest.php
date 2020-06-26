<?php


namespace Tests;


use DI\DependencyInjection\ContainerBag;
use PHPUnit\Framework\TestCase;

class ContainerBagTest extends TestCase
{
    private $containerBag;

    public function setUp(): void
    {
        $this->containerBag = new ContainerBag();
    }

}