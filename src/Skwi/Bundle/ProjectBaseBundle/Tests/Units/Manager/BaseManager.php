<?php

namespace Skwi\Bundle\ProjectBaseBundle\Tests\Units\Manager;

use atoum\AtoumBundle\Test\Units;
use Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Manager\FakeManager;

class BaseManager extends Units\Test
{
    /**
     * Test for createNew method
     */
    public function testCreateNew()
    {
        $this
            ->if($testedClass = $this->createTestedClass())
            ->then
                ->object($testedClass->createNew())
                    ->isInstanceOf('\Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Object\FakeObject')
                ->object($testedClass->createNew('OtherFakeObject'))
                    ->isInstanceOf('\Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Object\OtherFakeObject')
        ;
    }


    private function createTestedClass()
    {
        $testedClass = new FakeManager();

        $testedClass->setBundleName('FakeBundle');
        $testedClass->setBundleNamespace('Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle');

        $testedClass->setObjectManager(new \mock\Doctrine\Common\Persistence\ObjectManager());
        $testedClass->setObject('FakeBundle:FakeObject');

        return $testedClass;
    }
}
 