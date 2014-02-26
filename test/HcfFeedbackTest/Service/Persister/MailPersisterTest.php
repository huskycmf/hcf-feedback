<?php
namespace HcfFeedbackTest\Service\Persister;

use HcfFeedback\Service\Persister\MailPersister;
use Zend\Stdlib\Parameters;

class MailPersisterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $mailService;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $createData;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $factory;


    public function setUp()
    {
        $this->mailService = $this->getMock('HcCore\Service\MailService',
                                            array(), array(), '', false);

        $this->createData = $this->getMock('HcfFeedback\Data\CreateInterface',
                                           array(), array(), '', false);

        $this->factory = $this->getMock('HcfFeedback\Service\Mail\Message\FactoryInterface',
                                        array(), array(), '', false);
    }

    public function testPersisterOk()
    {
        $mailMessage = $this->getMock('Zend\Mail\Message');

        $this->mailService->expects($this->once())
                          ->method('send')
                          ->with($mailMessage);

        $this->factory->expects($this->once())
                      ->method('getMessage')
                      ->with($this->createData)
                      ->will($this->returnValue($mailMessage));

        $response = $this->getMock('Zf2Libs\Stdlib\Service\Response\Messages\Response');

        $response->expects($this->once())->method('success');
        $response->expects($this->any())->method('error');

        $mailPersister = new MailPersister($this->mailService, $this->factory, $response);
        $mailPersister->persist($this->createData);
    }

    public function testPersisterFail()
    {
        $mailMessage = $this->getMock('Zend\Mail\Message');

        $this->mailService->expects($this->once())
            ->method('send')
            ->with($mailMessage)->will($this->throwException(new \RuntimeException('Some thing wrong')));

        $this->factory->expects($this->once())
            ->method('getMessage')
            ->with($this->createData)
            ->will($this->returnValue($mailMessage));

        $response = $this->getMock('Zf2Libs\Stdlib\Service\Response\Messages\Response');

        $response->expects($this->once())->method('error');
        $response->expects($this->any())->method('success');

        $mailPersister = new MailPersister($this->mailService, $this->factory, $response);
        $mailPersister->persist($this->createData);
    }
}
