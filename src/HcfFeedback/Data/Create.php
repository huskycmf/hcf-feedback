<?php
namespace HcfFeedback\Data;

use HcfFeedback\Options\ModuleOptions;
use Zend\Http\PhpEnvironment\Request;
use Zf2Libs\Data\AbstractInputFilter;
use HcCore\Data\DataMessagesInterface;
use Zend\Di\Di;

class Create extends AbstractInputFilter
    implements CreateInterface, DataMessagesInterface
{
    /**
     * @param Request $request
     * @param Di $di
     * @param ModuleOptions $options
     */
    public function __construct(Request $request,
                                Di $di,
                                ModuleOptions $options)
    {
        $input = $di->get('Zend\InputFilter\Input', array('name'=>'name'));
        $input->setRequired($options->getNameFieldRequired());
        $input->getFilterChain()
              ->attach($di->get('Zend\Filter\StripTags'));
        $this->add($input);

        $input = $di->get('Zend\InputFilter\Input', array('name'=>'email'));
        $input->setRequired($options->getEmailFieldRequired());
        $input->getValidatorChain()
              ->attach($di->get('Zend\Validator\EmailAddress'));
        $this->add($input);

        $input = $di->get('Zend\InputFilter\Input', array('name'=>'message'));
        $input->setRequired($options->getMessageFieldRequired());
        $input->getFilterChain()->attach($di->get('Zend\Filter\StripTags'));
        $input->getValidatorChain()
              ->attach($di->get('Zend\Validator\StringLength', array('max'=>10000)));
        $this->add($input);

        $input = $di->get('Zend\InputFilter\Input', array('name'=>'phone'));
        $input->setRequired($options->getPhoneFieldRequired());
        $input->getValidatorChain()
            ->attach($di->get('Zend\Validator\StringLength', array('max'=>30)));
        $input->getFilterChain()
            ->attach($di->get('Zend\Filter\StripTags'))
            ->attach($di->get('Zend\Filter\StringTrim'));
        $this->add($input);

        $this->setData($request->getPost()->toArray());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getValue('name');
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->getValue('email');
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->getValue('phone');
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->getValue('message');
    }
}
