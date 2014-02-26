<?php
namespace HcfFeedbackTest\Service;

use HcfFeedback\Service\CreateCommand;
use Zend\Di\Di;
use Zend\Stdlib\Parameters;

class CreateCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecutionOk()
    {
        $createData = $this->getMock('\HcfFeedback\Data\CreateInterface',
                                     array(), array(), '', false);

        $persisterService = $this->getMock('\HcfFeedback\Service\Persister\PersisterInterface',
                                           array(), array(), '', false);

        $persisterService->expects($this->once())
                         ->method('persist')
                         ->with($createData);

        $createCommand = new CreateCommand($createData, $persisterService);
        $createCommand->execute();
    }
}
