<?php
namespace HcfFeedback\Service\Persister;

use HcCore\Service\Mail\Messages\FactoryInterface;
use HcCore\Service\MailService;
use HcfFeedback\Data\CreateInterface;
use Zf2Libs\Stdlib\Service\Response\Messages\Response as PersisterResponse;

class MailPersister implements PersisterInterface
{
    /**
     * @var MailService
     */
    protected $mailService;

    /**
     * @var FactoryInterface
     */
    protected $messageFactory;

    /**
     * @var PersisterResponse
     */
    protected $persisterResponse;

    /**
     * @param MailService $mailService
     * @param FactoryInterface $messageFactory
     * @param PersisterResponse $storeResponse
     */
    public function __construct(MailService $mailService,
                                FactoryInterface $messageFactory,
                                PersisterResponse $storeResponse)
    {
        $this->mailService = $mailService;
        $this->messageFactory = $messageFactory;
        $this->persisterResponse = $storeResponse;
    }

    /**
     * @param CreateInterface $createData
     * @return PersisterResponse
     */
    public function persist(CreateInterface $createData)
    {
        try {
            $this->mailService->send($this->messageFactory->getMessage($createData));
        } catch (\Exception $e) {
            return $this->persisterResponse->error($e->getMessage());
        }

        return $this->persisterResponse->success();
    }
}
