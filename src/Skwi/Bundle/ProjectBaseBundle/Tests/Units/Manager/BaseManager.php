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
                ->assert('Test createNew without constructor parameters')
                    ->object($testedClass->createNew())
                        ->isInstanceOf('\Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Object\FakeObject')
                    ->object($testedClass->createNew('OtherFakeObject'))
                        ->isInstanceOf('\Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Object\OtherFakeObject')
                    ->exception(function() use ($testedClass) {
                        $testedClass->createNew('UnknowClass');
                    })
                        ->isInstanceOf('\RuntimeException')
                ->assert('Test createNew with constructor parameter')
                    ->object($instance = $testedClass->createNew('FakeObjectWithConstructor', array('param1' => 'foo')))
                        ->isInstanceOf('\Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Object\FakeObjectWithConstructor')
                    ->string($instance->p1)
                        ->isEqualTo('foo')
                    ->string($instance->p2)
                        ->isEqualTo('bar')
                    ->object($instance = $testedClass->createNew('FakeObjectWithConstructor', array('param1' => 'foo', 'param2' => 'atoum')))
                        ->isInstanceOf('\Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Object\FakeObjectWithConstructor')
                    ->string($instance->p1)
                        ->isEqualTo('foo')
                    ->string($instance->p2)
                        ->isEqualTo('atoum')
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

    public function testGetAllByField()
    {
        $this
            ->given(
                $fields = array('field1' => 'value', 'field2' => 'value'),
                $orders = array('order1' => 'ASC', 'order2' => 'ASC'),
                $fieldsCall = array('field1' => 'value', 'field2' => 'value', 'status' => 1)
            )
            ->if($testedClass = $this->createTestedClass())
            ->given($testedClass->getAllByField($fields, true, $orders))
            ->then
                ->mock($this->mockRepository)
                    ->call('findBy')
                        ->withArguments($fieldsCall, $orders)
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
