<?php
namespace HcbClientTest\Service\Clients;

use HcbClient\Service\FetchQbBuilderService;

class FetchQbBuilderServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $entityManager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $sortingService;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestParams;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $queryBuilder;

    /**
     * Prepare the objects to be tested.
     */
    protected function setUp()
    {
        $this->entityManager = $this->getMock('\Doctrine\ORM\EntityManagerInterface',
                                              array(), array(), '', false);

        $this->queryBuilder = $this->getMock('\Doctrine\ORM\QueryBuilder',
                                             array(), array(), '', false);

        $this->queryBuilder->expects($this->once())
             ->method('where')->will($this->returnSelf());

        $this->queryBuilder->expects($this->once())->method('setParameter');

        $defaultRepository = $this->getMock('\Doctrine\ORM\EntityRepository',
                                            array(), array(), '', false);

        $defaultRepository->expects($this->once())
                          ->method('createQueryBuilder')
                          ->will($this->returnValue($this->queryBuilder));

        $this->entityManager->expects($this->once())
                            ->method('getRepository')
                            ->will($this->returnValue($defaultRepository));

        $this->sortingService =
            $this->getMock('\HcCore\Service\Sorting\SortingServiceInterface');

        $this->requestParams = $this->getMock('\Zend\Stdlib\Parameters');
    }

    public function testFetchWithoutParams()
    {
        $this->sortingService->expects($this->never())->method('apply');

        $service = new FetchQbBuilderService($this->entityManager, $this->sortingService);
        $this->assertInstanceOf('\Doctrine\ORM\QueryBuilder',
                                $service->fetch());
    }

    public function testFetchWithParams()
    {
        $this->sortingService->expects($this->once())
             ->method('apply')->will($this->returnArgument(1));

        $service = new FetchQbBuilderService($this->entityManager, $this->sortingService);
        $this->assertInstanceOf('\Doctrine\ORM\QueryBuilder',
                                $service->fetch($this->requestParams));
    }
}
