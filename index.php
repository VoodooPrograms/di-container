<?php

declare(strict_types=1);

require_once("customAutoload.php");

//
$container = new \DI\DependencyInjection\Container();
$container->set(\DI\Services\Service1\Profiler::class);
var_dump($container->get(\DI\Services\Service1\Profiler::class));

$container->set(DI\Services\Service2\AbstractService::class, DI\Services\Service2\Service::class);
var_dump($container->get(\DI\Services\Service2\AbstractService::class));

$container->set(DI\Services\Service2\AbstractService::class, DI\Services\Service2\AnotherService::class);
var_dump($container->get(\DI\Services\Service2\AbstractService::class));
$container->unset(\DI\Services\Service1\Profiler::class);
var_dump($container);


//$containerBag = new \DI\DependencyInjection\ContainerBag();
//$containerBag[\DI\Services\Profiler::class] = \DI\Services\Profiler::class;
//var_dump($containerBag[\DI\Services\Profiler::class]);

//$container = new \DI\DependencyInjection\Container();
//$container->set(\DI\Services\Profiler::class);
//$profiler = $container->get(\DI\Services\Profiler::class);
//var_dump($profiler);