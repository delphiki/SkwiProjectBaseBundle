<?php

namespace Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Object;

class FakeObject
{
    /** @var bool */
    private $status = true;

    public function setUpdatedAt()
    {
        return;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
}
