<?php

namespace Skwi\Bundle\ProjectBaseBundle\Tests;

use Skwi\Bundle\ProjectBaseBundle\Tests\ContainerAwareUnitTestCase;
use Skwi\Bundle\ProjectBaseBundle\Tests\Fake\FakeEntity;
use Skwi\Bundle\ProjectBaseBundle\Tests\Fake\FakeManager;

/**
 * Abstract Test case for Manager extending Novaway\Bundle\CrmBundle\Manager\BaseManager class.
 *
 * @author Cédric Spalvieri <cedric@novaway.fr>
 */
abstract class BaseManagerTestCase extends ContainerAwareUnitTestCase
{
    /** Tested objects **/
    protected $entityName;
    protected $entity;
    protected $manager;

    /**
     * TestCase set up
     */
    protected function setUp()
    {
        var_dump('toto');exit;
        $this->entityName = 'FakeEntity';
        $this->entity = new FakeEntity();

        $this->manager = new FakeManager();
        $this->manager->setEntityManager($this->getEmMock());
        $this->manager->setEntity($this->entityName);
        $this->manager->setBundleName('FakeBundle');
    }

    /**
     * Test for createNew method
     */
    public function testCreateNew()
    {
        $result = $this->manager->createNew($this->entityName);
        var_dump($result);exit;
    }

    /**
     * Returns a Mock Repository for the managed entity
     * @return EntityRepository The repository
     */
    protected function getRepoMock()
    {
        $repoMock  = $this->getMock(
            '\Novaway\Bundle\CrmBundle\Repository\\'.$this->entityName.'Repository',
            array('find'), array(), '', false);

        $repoMock
        ->expects($this->any())
        ->method('find')
        ->will($this->returnValue($this->entity));

        return $repoMock;
    }
}
