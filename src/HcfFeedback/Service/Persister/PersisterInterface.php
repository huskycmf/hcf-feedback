<?php
namespace HcfFeedback\Service\Persister;

use HcfFeedback\Data\CreateInterface;
use Zf2Libs\Stdlib\Service\Response\Messages\Response as PersistResponse;

interface PersisterInterface
{
    /**
     * @param CreateInterface $createData
     * @return PersistResponse
     */
    public function persist(CreateInterface $createData);
}
