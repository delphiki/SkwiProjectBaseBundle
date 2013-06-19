<?php

namespace Skwi\Bundle\ProjectBaseBundle\Tests\Manager;

use Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Entity\FakeEntity;
use Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Manager\FakeManager;
/**
 * Abstract Test case for Manager extending Novaway\Bundle\CrmBundle\Manager\BaseManager class.
 *
 * @author Cédric Spalvieri <cedric@novaway.fr>
 */
class BaseManagerTestCase extends \PHPUnit_Framework_TestCase
{
    protected $isEntityNew;

    /** Tested objects **/
    protected $entityName;
    protected $entity;
    protected $manager;

    /**
     * TestCase set up
     */
    protected function setUp()
    {
        $this->entityName = 'FakeEntity';
        $this->entity = new FakeEntity();

        $this->manager = new FakeManager();
        $this->manager->setBundleName('FakeBundle');
        $this->manager->setBundleNamespace('Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle');

        $this->manager->setEntityManager($this->getEmMock());
        $this->manager->setEntity($this->entityName);
    }

    /**
     * Test for createNew method
     */
    public function testCreateNew()
    {
        $result = $this->manager->createNew($this->entityName);

        $this->assertTrue($result instanceof FakeEntity);
    }

    /**
     * Returns a Mock Repository for the managed entity
     * @return EntityRepository The repository
     */
    protected function getRepoMock()
    {
        $repoMock  = $this->getMock(
            '\Skwi\Bundle\ProjectBaseBundle\Tests\FakeBundle\Repository\\'.$this->entityName.'Repository',
            array('find'), array(), '', false);

        $repoMock
        ->expects($this->any())
        ->method('find')
        ->will($this->returnValue($this->entity));

        return $repoMock;
    }

    protected function getEmMock()
    {
        /** UOW Mock **/
        $uowMock  = $this->getMock('\Doctrine\ORM\UnitOfWork',
            array('getEntityState'), array(), '', false);

        $uowMock->expects($this->any())
        ->method('getEntityState')
        ->will($this->returnValue(
            $this->isEntityNew ? \Doctrine\ORM\UnitOfWork::STATE_NEW : \Doctrine\ORM\UnitOfWork::STATE_MANAGED ));

        /** EM Mock **/
        $emMock  = $this->getMock('\Doctrine\ORM\EntityManager',
            array('getRepository', 'persist', 'flush', 'getUnitOfWork'),
            array(), '', false);

        $emMock->expects($this->any())
        ->method('getRepository')
        ->will($this->returnValue($this->getRepoMock()));

        $emMock->expects($this->any())
        ->method('persist')
        ->will($this->returnValue(null));

        $emMock->expects($this->any())
        ->method('flush')
        ->will($this->returnValue(null));

        $emMock->expects($this->any())
        ->method('getUnitOfWork')
        ->will($this->returnValue($uowMock));

        return $emMock;
    }
}
