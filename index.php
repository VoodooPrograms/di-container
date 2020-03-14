<?php

declare(strict_types=1);


/*
 * These part will be changed to Autoload class, maybe Composer autoload.
 * For now everyone should create class in namespaces that reflect directory structure
 */
set_include_path(dirname(getcwd()).DIRECTORY_SEPARATOR);

require_once("vendor/autoload.php");

spl_autoload_register(function ($path) {
    if (preg_match('/\\\\/', $path)) {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
    }
    if (file_exists(get_include_path()."${path}.php")) {
        require_once("${path}.php");
    }
});

//
//$container = new \DI\DependencyInjection\Container();
//$container->set(\DI\Services\Profiler::class);
////$container->set(\DI\Services\ProfilerDependencyA::class);
////$container->set(\DI\Services\ProfilerDependencyB::class);
////$container->set(\DI\Services\ProfilerDependencyC::class);
//var_dump($container->get(\DI\Services\Profiler::class));

//$containerBag = new \DI\DependencyInjection\ContainerBag();
//$containerBag[\DI\Services\Profiler::class] = \DI\Services\Profiler::class;
//var_dump($containerBag[\DI\Services\Profiler::class]);

$container = new \DI\DependencyInjection\Container();
$container->set(\DI\Services\Profiler::class);
$profiler = $container->get(\DI\Services\Profiler::class);
var_dump($profiler);