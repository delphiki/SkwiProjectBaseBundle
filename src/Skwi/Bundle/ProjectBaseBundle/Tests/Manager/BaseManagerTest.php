<?php

namespace Skwi\Bundle\ProjectBaseBundle\Test;

use Skwi\Bundle\ProjectBaseBundle\Tests\ContainerAwareUnitTestCase;

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
