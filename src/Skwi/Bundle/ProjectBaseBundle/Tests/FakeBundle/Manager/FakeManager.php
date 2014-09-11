<?php

namespace Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Manager;

use Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager;
use Doctrine\Common\Persistence\ObjectRepository;

class FakeManager extends BaseManager
{
    /**
     * @var ObjectRepository $otherFakeObjectRepository
     */
    protected  $otherFakeObjectRepository;

    /**
     * @param \Doctrine\Common\Persistence\ObjectRepository $otherFakeObjectRepository
     */
    public function setOtherFakeObjectRepository($otherFakeObjectRepository)
    {
        $this->otherFakeObjectRepository = $otherFakeObjectRepository;
    }
}
