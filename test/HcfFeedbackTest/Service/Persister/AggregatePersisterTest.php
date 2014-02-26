<?php
namespace HcfFeedbackTest\Service\Persister;

use HcfFeedback\Service\Persister\AggregatePersister;
use HcfFeedback\Service\Persister\MailPersister;
use Zend\Stdlib\Parameters;

class AggregatePersisterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $persister;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $response;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $createData;

    public function setUp()
    {
        $this->persister = $this->getMock('HcfFeedback\Service\Persister\PersisterInterface',
                                          array(), array(), '', false);

        $this->response = $this->getMock('Zf2Libs\Stdlib\Service\Response\Messages\Response');

        $this->createData = $this->getMock('HcfFeedback\Data\CreateInterface',
                                           array(), array(), '', false);
    }

    /**
     * @expectedException \HcfFeedback\Exception\RuntimeException
     */
    public function testFailIfEmpty()
    {
        $aggregatePersister = new AggregatePersister($this->response);
        $aggregatePersister->persist($this->createData);
    }

    public function testAggregatePersisterOk()
    {
        $successResponse = $this->getMock('Zf2Libs\Stdlib\Service\Response\Messages\Response');
        $successResponse->expects($this->once())->method('isFailed')->will($this->returnValue(false));

        $this->persister->expects($this->once())->method('persist')
             ->with($this->createData)->will($this->returnValue($successResponse));

        $this->response->expects($this->once())->method('success');
        $this->response->expects($this->any())->method('error');

        $aggregatePersister = new AggregatePersister($this->response);
        $aggregatePersister->addPersister($this->persister);
        $aggregatePersister->persist($this->createData);
    }

    public function testAggregateBreakTheCycleOnFail()
    {
        $failedResponse = $this->getMock('Zf2Libs\Stdlib\Service\Response\Messages\Response');
        $failedResponse->expects($this->once())->method('isFailed')->will($this->returnValue(true));

        $this->persister->expects($this->once())->method('persist')
             ->with($this->createData)->will($this->returnValue($failedResponse));

        $deadPersister = $this->getMock('HcfFeedback\Service\Persister\PersisterInterface',
                                        array(), array(), '', false);
        $deadPersister->expects($this->never())->method('persist');
        $this->response->expects($this->never())->method('success');

        $aggregatePersister = new AggregatePersister($this->response);

        $aggregatePersister->addPersister($this->persister);
        $aggregatePersister->addPersister($deadPersister);

        $this->assertEquals($failedResponse, $aggregatePersister->persist($this->createData));
    }
}
