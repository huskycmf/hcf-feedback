<?php
namespace HcfFeedback\Service\Persister;

use HcfFeedback\Data\CreateInterface;
use HcfFeedback\Exception\RuntimeException;
use Zf2Libs\Stdlib\Service\Response\Messages\Response as PersisterResponse;

class AggregatePersister implements PersisterInterface
{
    /**
     * @var PersisterInterface[]
     */
    protected $persisters = array();

    /**
     * @var PersisterResponse
     */
    protected $persisterResponse;

    /**
     * @param PersisterResponse $persisterResponse
     */
    public function __construct(PersisterResponse $persisterResponse)
    {
        $this->persisterResponse = $persisterResponse;
    }

    /**
     * @param PersisterInterface $processor
     * @return $this
     */
    public function addPersister(PersisterInterface $persister)
    {
        $this->persisters[] = $persister;
        return $this;
    }

    /**
     * @param CreateInterface $createData
     * @return PersisterResponse
     */
    public function persist(CreateInterface $createData)
    {
        if (!count($this->persisters)) {
            throw new RuntimeException('Empty persisters array, could not persist message');
        }

        foreach ($this->persisters as $persister) {
            $response = $persister->persist($createData);
            if ($response->isFailed()) {
                return $response;
            }
        }

        return $this->persisterResponse->success();
    }
}
