<?php

declare(strict_types=1);

use DI\DependencyInjection\ContainerBag;
use Services\Service1\Profiler;
use Services\Service2\AbstractService;
use DI\DependencyInjection\Container;

//require_once("customAutoload.php");
require_once 'vendor/autoload.php';

//
$container = new Container();
$container->set('service', function() {
   return new stdClass();
});

var_dump($container->get('service'));

$container->set(Profiler::class);
var_dump($container->get(Profiler::class));

$container->set(Services\Service2\AbstractService::class, Services\Service2\Service::class);
var_dump($container->get(AbstractService::class));

$container->set(Services\Service2\AbstractService::class, Services\Service2\AnotherService::class);
var_dump($container->get(AbstractService::class));
$container->unset(Profiler::class);
var_dump($container);


$containerBag = new ContainerBag();
$containerBag[Profiler::class] = Profiler::class;
var_dump($containerBag[Profiler::class]);

$container = new Container();
$container->set(Profiler::class);
$profiler = $container->get(Profiler::class);
var_dump($profiler);