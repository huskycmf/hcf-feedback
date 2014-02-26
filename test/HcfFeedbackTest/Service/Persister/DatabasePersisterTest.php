<?php
namespace HcfFeedbackTest\Service\Persister;

use HcfFeedback\Service\Persister\DatabasePersister;
use Zend\Di\Di;
use Zend\Stdlib\Parameters;

class DatabasePersisterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $entityManager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $createData;

    public function setUp()
    {
        $this->entityManager = $this->getMock('Doctrine\ORM\EntityManagerInterface',
                                               array(), array(), '', false);

        $this->createData = $this->getMock('HcfFeedback\Data\CreateInterface',
                                           array(), array(), '', false);

        $this->createData->expects($this->once())->method('getName');
        $this->createData->expects($this->once())->method('getEmail');
        $this->createData->expects($this->once())->method('getPhone');
        $this->createData->expects($this->once())->method('getMessage');
    }

    public function testPersisterOk()
    {
        $response = $this->getMock('Zf2Libs\Stdlib\Service\Response\Messages\Response');

        $this->entityManager->expects($this->once())->method('beginTransaction');
        $this->entityManager->expects($this->once())
                            ->method('persist')
                            ->with($this->isInstanceOf('HcfFeedback\Entity\Feedback'));

        $this->entityManager->expects($this->once())->method('flush');
        $this->entityManager->expects($this->once())->method('commit');

        $response->expects($this->once())->method('success');
        $response->expects($this->any())->method('error');

        $mailPersister = new DatabasePersister($this->entityManager, $response);
        $mailPersister->persist($this->createData);
    }

    public function testExecutionFail()
    {
        $response = $this->getMock('Zf2Libs\Stdlib\Service\Response\Messages\Response');

        $this->entityManager->expects($this->once())->method('beginTransaction');
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf('HcfFeedback\Entity\Feedback'));

        $this->entityManager->expects($this->once())->method('flush');
        $this->entityManager->expects($this->once())
             ->method('commit')
             ->will($this->throwException(new \RuntimeException()));

        $response->expects($this->once())->method('error');
        $response->expects($this->any())->method('success');

        $mailPersister = new DatabasePersister($this->entityManager, $response);
        $mailPersister->persist($this->createData);
    }
}
