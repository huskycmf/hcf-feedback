<?php
namespace HcfFeedback\Service;

use HcCore\Service\CommandInterface;
use HcfFeedback\Data\CreateInterface;
use HcfFeedback\Service\Persister\PersisterInterface;
use Zf2Libs\Stdlib\Service\Response\Messages\Response;

class CreateCommand implements CommandInterface
{
    /**
     * @var CreateInterface
     */
    protected $createData;

    /**
     * @var PersisterInterface
     */
    protected $persister;

    /**
     * @param CreateInterface $createData
     * @param PersisterInterface $persister
     */
    public function __construct(CreateInterface $createData,
                                PersisterInterface $persister)
    {
        $this->createData = $createData;
        $this->persister = $persister;
    }

    /**
     * @return Response
     */
    public function execute()
    {
        return $this->persister->persist($this->createData);
    }
}
