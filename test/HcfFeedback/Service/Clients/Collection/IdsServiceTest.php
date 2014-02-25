<?php
namespace HcbClientTest\Service\Clients\Collection;

use Doctrine\ORM\Query\Expr;
use HcbClient\Entity\User as ClientEntity;
use HcbClient\Service\Collection\IdsService;

class IdsServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testFetch()
    {
        $entityManager = $this->getMock('\Doctrine\ORM\EntityManagerInterface',
                                        array(), array(), '', false);

        $queryBuilder = $this->getMock('\Doctrine\ORM\QueryBuilder',
                                       array(), array(), '', false);

        $defaultRepository = $this->getMock('\Doctrine\ORM\EntityRepository',
                                            array(), array(), '', false);

        $client = new ClientEntity();

        $query = $this->getMock('\stdClass', array('getResult'));
        $query->expects($this->once())->method('getResult')
              ->will($this->returnValue(array($client)));

        $queryBuilder->expects($this->once())->method('getQuery')
                     ->will($this->returnValue($query));

        $expr = $this->getMock('Doctrine\ORM\Query\Expr');

        $queryBuilder->expects($this->any())->method('expr')->will($this->returnValue($expr));

        $defaultRepository->expects($this->once())
                          ->method('createQueryBuilder')
                          ->will($this->returnValue($queryBuilder));

        $entityManager->expects($this->once())
                      ->method('getRepository')
                      ->will($this->returnValue($defaultRepository));

        $idsService = new IdsService($entityManager);

        $this->assertEquals(array($client), $idsService->fetch(array(1,2,3)));
    }
}
