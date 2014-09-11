<?php

namespace Skwi\Bundle\ProjectBaseBundle\Tests\Units\Manager;

use atoum\AtoumBundle\Test\Units;
use Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Manager\FakeManager;

class BaseManager extends Units\Test
{
    /** @var \Doctrine\Common\Persistence\ObjectManager */
    private $mockObjectManager;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $mockRepository;
    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $mockOtherRepository;
    /** @var \Doctrine\ORM\Query */
    private $mockQuery;
    /** @var \Doctrine\ORM\QueryBuilder */
    private $mockQueryBuilder;

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

    public function testGetStateProperty()
    {
        $this
            ->given($testedClass = $this->createTestedClass())
            ->if($testedClass->setObject('FakeBundle:FakeObject'))
            ->then
                ->string($testedClass->getStateProperty())
                    ->isEqualTo('status')
            ->if($testedClass->setObject('FakeBundle:OtherFakeObject'))
            ->then
                ->string($testedClass->getStateProperty())
                    ->isEqualTo('state')
            ->if($testedClass->setStateProperty('fakeProperty'))
            ->then
                ->string($testedClass->getStateProperty())
                    ->isEqualTo('fakeProperty')
            ->if($testedClass->setObject('FakeBundle:EmptyFakeObject'))
                ->then
                    ->variable($testedClass->getStateProperty())
                    ->isEqualTo(null)
        ;
    }

    public function testGetStateValue()
    {
        $this
            ->given($testedClass = $this->createTestedClass())
            ->then
                ->variable($testedClass->getStateActiveValue())
                    ->isEqualTo(true)
            ->if($testedClass->setStateProperty('fakeProperty', 1))
            ->then
                ->variable($testedClass->getStateActiveValue())
                    ->isEqualTo(1)
        ;
    }

    public function testSave()
    {
        $this
            ->given(
                $testedClass = $this->createTestedClass(),
                $object = new \mock\Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Object\FakeObject()
            )
            ->if($testedClass->save($object))
            ->then
                ->mock($object)
                    ->call('setUpdatedAt')->once()
                ->mock($this->mockObjectManager)
                    ->call('persist')->once()
                    ->call('flush')->once()

        ;
    }

    public function testDelete()
    {
        $this
            ->given(
                $testedClass = $this->createTestedClass(),
                $object = new \mock\Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Object\FakeObject()
            )
            ->if($testedClass->delete($object))
            ->then
                ->mock($this->mockObjectManager)
                    ->call('remove')->once()
                    ->call('flush')->once()

        ;
    }

    public function testFind()
    {
        $this
            ->given(
                $testedClass = $this->createTestedClass()
            )

            ->assert('Find default managed entity')
            ->if($testedClass->find(12))
            ->then
                ->mock($this->mockRepository)
                    ->call('find')
                        ->withArguments(12)
                        ->once()

            ->assert('Find other managed entity')
            ->if($testedClass->find(48, 'OtherFakeObject'))
            ->then
                ->mock($this->mockOtherRepository)
                    ->call('find')
                        ->withArguments(48)
                        ->once()

        ;
    }

    public function testFindAll()
    {
        $this
            ->given(
                $testedClass = $this->createTestedClass()
            )

            ->assert('Find All with inactive')
            ->if($testedClass->findAll(false))
            ->then
                ->mock($this->mockQueryBuilder)
                    ->call('andWhere')
                        ->never()

            ->assert('Find All only active')
            ->if($testedClass->findAll())
            ->then
                ->mock($this->mockRepository)
                    ->call('createQueryBuilder')
                        ->once()
                ->mock($this->mockQueryBuilder)
                    ->call('andWhere')
                        ->withArguments('o.status = 1')
                        ->once()
                ->mock($this->mockQueryBuilder)
                    ->call('getQuery')
                        ->once()
                ->mock($this->mockQuery)
                    ->call('getResult')
                        ->once()
        ;
    }

    public function testFindAllInRange()
    {
        $this
            ->given(
                $testedClass = $this->createTestedClass()
            )
            ->if($testedClass->findAllInRange(10, 30))
            ->then
                ->mock($this->mockQueryBuilder)
                    ->call('setMaxResults')
                        ->withArguments(30)
                        ->once()
                    ->call('setFirstResult')
                        ->withArguments(10)
                        ->once()
                ->mock($this->mockQuery)
                    ->call('getResult')
                    ->once()
        ;
    }

    public function testToggleState()
    {
        $this
            ->given(
                $testedClass = $this->createTestedClass(),
                $object      = $testedClass->createNew()
            )
            ->if($testedClass->toggleState($object))
            ->then
                ->boolean($object->getStatus())
                ->isEqualTo(false)
            ->if(
                $testedClass->setObject('FakeBundle:EmptyFakeObject'),
                $object = $testedClass->createNew()
            )
            ->then
                ->exception(
                    function() use($testedClass, $object) {
                        $testedClass->toggleState($object);
                    }
                )
                ->isInstanceOf('\RuntimeException')
        ;
    }


    private function createTestedClass()
    {
        $testedClass = new FakeManager();

        $testedClass->setBundleName('FakeBundle');
        $testedClass->setBundleNamespace('Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle');

        $this->mockClass('Doctrine\Orm\QueryBuilder', '\Mock');
        $this->mockQuery        = new \mock\Dummy();
        $this->mockQueryBuilder = new \mock\Dummy();
        $q                      = $this->mockQuery;
        $qb                     = $this->mockQueryBuilder;
        $this->mockQueryBuilder->getMockController()->getQuery       = function() use ($q) { return $q; };
        $this->mockQueryBuilder->getMockController()->setFirstResult = function() use ($qb) { return $qb; };
        $this->mockQueryBuilder->getMockController()->setMaxResults  = function() use ($qb) { return $qb; };

        $this->mockRepository      = new\mock\Doctrine\Common\Persistence\ObjectRepository();
        $this->mockOtherRepository = new\mock\Doctrine\Common\Persistence\ObjectRepository();
        $repo                      = $this->mockRepository;

        $this->mockRepository->getMockController()->createQueryBuilder = function() use ($qb) { return $qb; };

        $this->mockObjectManager = new \mock\Doctrine\Common\Persistence\ObjectManager();
        $this->mockObjectManager->getMockController()->getRepository = function() use ($repo) { return $repo; };
        $testedClass->setOtherFakeObjectRepository($this->mockOtherRepository);

        $testedClass->setObjectManager($this->mockObjectManager);
        $testedClass->setObject('FakeBundle:FakeObject');

        return $testedClass;
    }
}
 