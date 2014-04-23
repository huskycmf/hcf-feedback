<?php
namespace HcfFeedback\Service\Mail\Message;

use HcfFeedback\Data\CreateInterface;
use HcfFeedback\Options\ModuleOptions;
use Zend\Di\Di;
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
     * @var Di
     */
    protected $di;

    /**
     * @param ModuleOptions $options
     * @param Di $di
     */
    public function __construct(ModuleOptions $options,
                                Di $di)
    {
        $this->options = $options;
        $this->di = $di;
    }

    /**
     * @return MailMessage
     */
    public function getMessage(CreateInterface $createData)
    {
        $emailTo = $this->options->getEmailTo();
        if (!strlen($emailTo)) {
            throw new RuntimeException("Email address [to] must be defined in configuration");
        }

        /* @var $message \Zend\Mail\Message */
        $message = $this->di->get('Zend\Mail\Message');

        $message->setTo($emailTo);

        $message->addCc($this->options->getEmailCc());
        $message->addBcc($this->options->getEmailBcc());

        $message->setFrom($this->options->getEmailFrom());
        $message->setSubject($this->options->getEmailSubject());

        $body = "<div>Name: <b>".$createData->getName()."</b>
                 <div>Email:".$createData->getEmail()."</div>
                 <div>Phone:".$createData->getPhone()."</div>";

        $body.= sprintf("<div>Message: <br/><pre>".
                            $createData->getMessage()."</pre></div>");

        $bodyPart = $this->di->get('Zend\Mime\Message');

        $bodyMessage = $this->di->get('Zend\Mime\Part',
                                      array('content'=>$body));
        $bodyMessage->type = 'text/html';

        $bodyPart->setParts(array($bodyMessage));

        $message->setBody($bodyPart);
        $message->setEncoding('UTF-8');

        return $message;
    }
}
