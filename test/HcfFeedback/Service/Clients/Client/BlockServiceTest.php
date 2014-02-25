<?php
namespace HcbClientTest\Service\Clients\Client;

use HcbClient\Entity\User as ClientEntity;
use HcbClient\Service\BlockService;

;

class BlockServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $entityManager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $blockData;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $response;

    public function setUp()
    {
        $this->entityManager = $this->getMock('\Doctrine\ORM\EntityManagerInterface', array(), array(), '', false);
        $this->blockData = $this->getMock('HcbClient\Data\Clients\BlockInterface');
        $this->response = $this->getMock('Zf2Libs\Stdlib\Service\Response\Messages\Response');
    }

    public function testBlockFailed()
    {
        $this->blockData->expects($this->once())->method('getClients')
             ->will($this->returnCallback(function (){
                throw new \Exception('Error');
            }));

        $this->response->expects($this->once())->method('error')->with('Error')->will($this->returnSelf());
        $this->response->expects($this->once())->method('failed');

        $this->entityManager->expects($this->once())->method('beginTransaction');
        $this->entityManager->expects($this->once())->method('rollback');

        $service = new BlockService($this->entityManager, $this->response);
        $this->assertEquals($this->response, $service->block($this->blockData));

    }

    public function testBlockSuccess()
    {
        $client1 = $this->getMock('HcbClient\Entity\User');
        $client1->expects($this->once())
                ->method('setState')
                ->with(Client::STATE_BLOCKED);

        $client2 = $this->getMock('HcbClient\Entity\User');
        $client2->expects($this->once())
                ->method('setState')
                ->with(Client::STATE_BLOCKED);

        $this->blockData->expects($this->once())->method('getClients')
             ->will($this->returnValue(array($client1, $client2)));

        $this->entityManager->expects($this->at(1))
                      ->method('persist')
                      ->with($client1);

        $this->entityManager->expects($this->at(2))
                      ->method('persist')
                      ->with($client2);


        $this->response->expects($this->once())->method('success');

        $this->entityManager->expects($this->once())->method('beginTransaction');
        $this->entityManager->expects($this->once())->method('flush');
        $this->entityManager->expects($this->once())->method('commit');

        $service = new BlockService($this->entityManager, $this->response);
        $this->assertEquals($this->response, $service->block($this->blockData));
    }
}
