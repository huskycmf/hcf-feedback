<?php
namespace HcfFeedback\Service\Persister;

use Doctrine\ORM\EntityManagerInterface;
use HcfFeedback\Data\CreateInterface;
use HcfFeedback\Entity\Feedback;
use Zf2Libs\Stdlib\Service\Response\Messages\Response as PersisterResponse;

class DatabasePersister implements PersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var PersisterResponse
     */
    protected $persisterResponse;

    /**
     * @param EntityManagerInterface $entityManager
     * @param PersisterResponse $persisterResponse
     */
    public function __construct(EntityManagerInterface $entityManager,
                                PersisterResponse $persisterResponse)
    {
        $this->entityManager = $entityManager;
        $this->persisterResponse = $persisterResponse;
    }

    /**
     * @param CreateInterface $createData
     * @return PersisterResponse
     */
    public function persist(CreateInterface $createData)
    {
        try {
            $this->entityManager->beginTransaction();

            $feedbackEntity = new Feedback();
            $feedbackEntity->setEmail($createData->getEmail());
            $feedbackEntity->setPhone($createData->getPhone());
            $feedbackEntity->setMessage($createData->getMessage());
            $feedbackEntity->setName($createData->getName());

            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            return $this->persisterResponse->error($e->getMessage());
        }

        return $this->persisterResponse->success();
    }
}
