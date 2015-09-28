<?php

namespace UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme;

use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableTrait;
use UniAlteri\States\Proxy\Integrated;

class Acme extends Integrated implements LifeCyclableInterface
{
    use LifeCyclableTrait;
}