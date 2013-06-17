<?php

namespace Skwi\Bundle\ProjectBaseBundle\Test;

require_once __DIR__.'/../../../../../app/AppKernel.php';

abstract class ContainerAwareUnitTestCase extends \PHPUnit_Framework_TestCase
{
    protected static $kernel;
    protected static $container;

    protected $isEntityNew;

    public static function setUpBeforeClass()
    {
        self::$kernel = new \AppKernel('dev', true);
        self::$kernel->boot();

        self::$container = self::$kernel->getContainer();
    }

    public function get($serviceId)
    {
        return self::$kernel->getContainer()->get($serviceId);
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

    abstract protected function getRepoMock();
}
