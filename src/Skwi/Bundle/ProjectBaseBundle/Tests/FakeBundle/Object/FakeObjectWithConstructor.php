<?php

namespace Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Object;

class FakeObjectWithConstructor extends FakeObject
{
    public $p1;
    public $p2;

    public function __construct($param1, $param2 = 'bar')
    {
        $this->p1 = $param1;
        $this->p2 = $param2;
    }
}
