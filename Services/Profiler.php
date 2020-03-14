<?php


namespace DI\Services;


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
