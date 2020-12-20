

features:

Create a container
```
use DI\DependencyInjection\Container;

$container = new Container();
```

Define a service

```
$container->set('service', function() {
   return new stdClass();
});
```

```
$container->set(Profiler::class);

```

```
use DI\DependencyInjection\ContainerBag;

$containerBag = new ContainerBag();
$containerBag[Profiler::class] = Profiler::class;
```

Get a service

```
$container->get('service')
```

```
$containerBag[Profiler::class]
```

Define a dependency by constructor

Profile service class. We have to set dependencies as types of parameters in the `__construct` method.

```
class Profiler implements IProfiler
{
    private $dep1;
    private $dep2;
    private $dep3;

    public function __construct(
        ProfilerDependencyA $dep1,
        ProfilerDependencyB $dep2,
        ProfilerDependencyC $dep3
    )
    {
        $this->dep1 = $dep1;
        $this->dep2 = $dep2;
        $this->dep3 = $dep3;
    }

    public function dump()
    {
        // TODO: Implement dump() method.
    }
}
```