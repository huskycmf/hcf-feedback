<?php
namespace HcfFeedbackTest\Service\Mail\Message;

use HcfFeedback\Service\Mail\Message\CommonFactory;
use Zend\Di\Di;
use Zend\Stdlib\Parameters;

class CommonFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $moduleOptions;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $createData;

    public function setUp()
    {
        $this->moduleOptions = $this->getMock('\HcfFeedback\Options\ModuleOptions');

        $this->moduleOptions->expects($this->once())
            ->method('getEmailTo')
            ->will($this->returnValue('test@gmail.com'));

        $this->moduleOptions->expects($this->once())
            ->method('getEmailFrom')
            ->will($this->returnValue('from@gmail.com'));

        $this->moduleOptions->expects($this->once())
            ->method('getEmailSubject')
            ->will($this->returnValue('test subject value'));

        $this->createData = $this->getMock('\HcfFeedback\Data\CreateInterface',
            array(), array(), '', false);

        $this->createData->expects($this->once())->method('getName');
        $this->createData->expects($this->once())->method('getEmail');
        $this->createData->expects($this->once())->method('getPhone');
        $this->createData->expects($this->once())->method('getMessage');
    }

    public function testExecutionOk()
    {
        $factory = new CommonFactory($this->moduleOptions, new Di());

        $mailMessage = $factory->getMessage($this->createData);
        $this->assertInstanceOf('Zend\Mail\Message', $mailMessage);
    }

    public function testIsMailMessageCorrect()
    {
        $factory = new CommonFactory($this->moduleOptions, new Di());
        $mailMessage = $factory->getMessage($this->createData);

        $this->assertInstanceOf('Zend\Mail\Address', $mailMessage->getTo()->get('test@gmail.com'));
        $this->assertInstanceOf('Zend\Mail\Address', $mailMessage->getFrom()->get('from@gmail.com'));
        $this->assertEquals('test subject value', $mailMessage->getSubject());
    }
}
