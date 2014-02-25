<?php
namespace HcfFeedback\Service\Mail\Message;

use HcfFeedback\Data\CreateInterface;
use HcfFeedback\Options\ModuleOptions;
use Zend\Mail\Message as MailMessage;
use HcfFeedback\Exception\RuntimeException;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class CommonFactory implements FactoryInterface
{
    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * @param ModuleOptions $options
     */
    public function __construct(ModuleOptions $options)
    {
        $this->options = $options;
    }

    /**
     * @return MailMessage
     */
    public function getMessage(CreateInterface $createData)
    {
        $message = new MailMessage();

        if (!strlen($this->options->getEmailTo())) {
            throw new RuntimeException("Email address [to] must be defined in configuration");
        }

        $message->setTo($this->options->getEmailTo());
        $message->setFrom($this->options->getEmailFrom());
        $message->setSubject($this->options->getEmailSubject());

        $body = "<div>Name: <b>".$createData->getName()."</b>
                 <div>Email:".$createData->getEmail()."</div>
                 <div>Phone:".$createData->getPhone()."</div>";

        $body.= sprintf("<div>Message: <br/><pre>".
                            $createData->getMessage()."</pre></div>");

        $bodyPart = new MimeMessage();

        $bodyMessage = new MimePart($body);
        $bodyMessage->type = 'text/html';

        $bodyPart->setParts(array($bodyMessage));

        $message->setBody($bodyPart);
        $message->setEncoding('UTF-8');

        return $message;
    }
}
