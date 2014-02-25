<?php
namespace HcbClientTest\Service\Clients\Client;

use HcbClient\Service\BlockService;

class BlockCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $blockData = $this->getMock('HcbClient\Data\Clients\BlockInterface');
        $blockService = $this->getMock('HcbClient\Service\Client\BlockService',
                                       array(), array(), '', false);
        $response = $this->getMock('Zf2Libs\Stdlib\Service\Response\Messages\Response');

        $blockService->expects($this->once())
                     ->method('block')
                     ->with($blockData)
                     ->will($this->returnValue($response));

        $command = new BlockCommand($blockData, $blockService);
        $this->assertEquals($response, $command->execute());
    }
}
