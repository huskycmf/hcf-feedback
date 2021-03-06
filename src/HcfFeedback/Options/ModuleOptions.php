<?php
namespace HcfFeedback\Options;

use HcCore\Options\Exception;
use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $emailTo = '';

    /**
     * @var array
     */
    protected $emailCc = array();

    /**
     * @var array
     */
    protected $emailBcc = array();

    /**
     * @var string
     */
    protected $emailFrom = 'noreplay@localhost.localdomain';

    /**
     * @var string
     */
    protected $emailSubject = '[Сообщение из формы контактов]';

    /**
     * @var bool
     */
    protected $nameFieldRequired = false;

    /**
     * @var bool
     */
    protected $emailFieldRequired = false;

    /**
     * @var bool
     */
    protected $phoneFieldRequired = false;

    /**
     * @var bool
     */
    protected $messageFieldRequired = false;

    /**
     * @param string $emailTo
     */
    public function setEmailTo($emailTo)
    {
        $this->emailTo = $emailTo;
    }

    /**
     * @return string
     */
    public function getEmailTo()
    {
        return $this->emailTo;
    }

    /**
     * @param array $emailCc
     */
    public function setEmailCc($emailCc)
    {
        if (!is_array($emailCc)) {
            throw new \InvalidArgumentException('Invalid argument type, array expected '.var_export($emailCc, true));
        }
        $this->emailCc = $emailCc;
    }

    /**
     * @return array
     */
    public function getEmailCc()
    {
        return $this->emailCc;
    }

    /**
     * @param array $emailBcc
     */
    public function setEmailBcc($emailBcc)
    {
        if (!is_array($emailBcc)) {
            throw new \InvalidArgumentException('Invalid argument type, array expected '.var_export($emailBcc, true));
        }
        $this->emailBcc = $emailBcc;
    }

    /**
     * @return array
     */
    public function getEmailBcc()
    {
        return $this->emailBcc;
    }

    /**
     * @param string $emailFrom
     */
    public function setEmailFrom($emailFrom)
    {
        $this->emailFrom = $emailFrom;
    }

    /**
     * @return string
     */
    public function getEmailFrom()
    {
        return $this->emailFrom;
    }

    /**
     * @param string $emailSubject
     */
    public function setEmailSubject($emailSubject)
    {
        $this->emailSubject = $emailSubject;
    }

    /**
     * @return string
     */
    public function getEmailSubject()
    {
        return $this->emailSubject;
    }

    /**
     * @param boolean $emailFieldRequired
     */
    public function setEmailFieldRequired($emailFieldRequired)
    {
        $this->emailFieldRequired = $emailFieldRequired;
    }

    /**
     * @return boolean
     */
    public function getEmailFieldRequired()
    {
        return $this->emailFieldRequired;
    }

    /**
     * @param boolean $nameFieldRequired
     */
    public function setNameFieldRequired($nameFieldRequired)
    {
        $this->nameFieldRequired = $nameFieldRequired;
    }

    /**
     * @return boolean
     */
    public function getNameFieldRequired()
    {
        return $this->nameFieldRequired;
    }

    /**
     * @param boolean $phoneFieldRequired
     */
    public function setPhoneFieldRequired($phoneFieldRequired)
    {
        $this->phoneFieldRequired = $phoneFieldRequired;
    }

    /**
     * @return boolean
     */
    public function getPhoneFieldRequired()
    {
        return $this->phoneFieldRequired;
    }

    /**
     * @param boolean $messageFieldRequired
     */
    public function setMessageFieldRequired($messageFieldRequired)
    {
        $this->messageFieldRequired = $messageFieldRequired;
    }

    /**
     * @return boolean
     */
    public function getMessageFieldRequired()
    {
        return $this->messageFieldRequired;
    }
}
