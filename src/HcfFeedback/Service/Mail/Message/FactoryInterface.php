<?php
namespace HcfFeedback\Service\Mail\Message;

use HcfFeedback\Data\CreateInterface;
use Zend\Mail\Message as MailMessage;

interface FactoryInterface
{
    /**
     * @return MailMessage
     */
    public function getMessage(CreateInterface $createData);
}
