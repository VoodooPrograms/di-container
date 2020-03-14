<?php


namespace DI\Services;


class ProfilerDependencyC
{
    public function __construct(ProfilerDependencyA $a)
    {
        $this->a = $a;
    }
}
