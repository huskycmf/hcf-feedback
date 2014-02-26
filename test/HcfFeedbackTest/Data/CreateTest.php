<?php
namespace HcfFeedbackTest\Data;

use HcfFeedback\Data\Create;
use Zend\Di\Di;
use Zend\Stdlib\Parameters;
use HcfFeedback\Options\ModuleOptions;

class CreteTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptySuccess()
    {
        $di = new Di();
        $moduleOptions = new ModuleOptions();
        $createData = new Create($di, $moduleOptions);
        $createData->setData(array());
        $this->assertTrue($createData->isValid());
    }

    public function testEmailValidationFailed()
    {
        $di = new Di();
        $moduleOptions = new ModuleOptions();
        $createData = new Create($di, $moduleOptions);
        $createData->setData(array('name'=>'test', 'email'=>'test'));

        $this->assertFalse($createData->isValid());
        $this->assertArrayHasKey('email', $createData->getInvalidInput());
    }

    public function testBasicSuccess()
    {
        $di = new Di();
        $moduleOptions = new ModuleOptions();
        $createData = new Create($di, $moduleOptions);
        $createData->setData(array('name'=>'test test test',
                                   'email'=>'test@gmail.com',
                                   'message'=>str_repeat('ba', 5000)));

        $this->assertTrue($createData->isValid());
    }

    public function testAllFieldsAreNotRequiredByDefault()
    {
        $di = new Di();
        $moduleOptions = new ModuleOptions();
        $createData = new Create($di, $moduleOptions);
        foreach ($createData->getInputs() as $input) {
            $this->assertFalse($input->isRequired());
        }
    }

    /**
     * @return array
     */
    public function providerRequiredFields()
    {
        return array(array('email'), array('name'), array('message'), array('phone'));
    }

    /**
     * @return array
     */
    public function providerGettersValues()
    {
        return array(array('email', 'test@gmail.com'), array('name', 'test'), array('message', str_repeat('a', 1000)), array('phone', '+380661087656'));
    }

    /**
     * @dataProvider providerRequiredFields
     */
    public function testRequiredEmailModuleOptions($key)
    {
        $di = new Di();
        $moduleOptions = new ModuleOptions();
        $method = 'set'.ucfirst($key).'FieldRequired';
        $moduleOptions->$method(true);

        $createData = new Create($di, $moduleOptions);
        $inputs = $createData->getInputs();
        $this->assertTrue($inputs[$key]->isRequired());
    }

    /**
     * @dataProvider providerGettersValues
     */
    public function testAllGetters($key, $value)
    {
        $di = new Di();
        $moduleOptions = new ModuleOptions();

        $createData = new Create($di, $moduleOptions);
        $createData->setData(array($key=>$value));

        $this->assertEquals($value, $createData->{"get".ucfirst($key)}());
    }
}
