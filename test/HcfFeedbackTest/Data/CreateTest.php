<?php
namespace HcfFeedbackTest\Data;

use HcfFeedback\Data\Create;
use Zend\Di\Di;
use Zend\Stdlib\Parameters;
use HcfFeedback\Options\ModuleOptions;

class CreteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestParams;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $request;

    /**
     * Prepare the objects to be tested.
     */
    protected function setUp()
    {
        $this->request = $this->getMock('\Zend\Http\PhpEnvironment\Request');
        $this->requestParams = $this->getMock('\Zend\Stdlib\Parameters');

        $this->request->expects($this->any())
             ->method('getPost')
             ->will($this->returnValue($this->requestParams));
    }

    public function testEmptySuccess()
    {
        $di = new Di();
        $moduleOptions = new ModuleOptions();

        $this->requestParams->expects($this->any())
             ->method('toArray')->will($this->returnValue(array()));

        $createData = new Create($this->request, $di, $moduleOptions);
        $this->assertTrue($createData->isValid());
    }

    public function testEmailValidationFailed()
    {
        $di = new Di();
        $moduleOptions = new ModuleOptions();

        $this->requestParams->expects($this->any())->method('toArray')
             ->will($this->returnValue(array('name'=>'test', 'email'=>'test')));

        $createData = new Create($this->request, $di, $moduleOptions);

        $this->assertFalse($createData->isValid());
        $this->assertArrayHasKey('email', $createData->getInvalidInput());
    }

    public function testBasicSuccess()
    {
        $di = new Di();
        $moduleOptions = new ModuleOptions();

        $this->requestParams->expects($this->any())->method('toArray')
             ->will($this->returnValue(array('name'=>'test test test',
                                             'email'=>'test@gmail.com',
                                             'message'=>str_repeat('ba', 5000))));

        $createData = new Create($this->request, $di, $moduleOptions);

        $this->assertTrue($createData->isValid());
    }

    public function testAllFieldsAreNotRequiredByDefault()
    {
        $di = new Di();
        $moduleOptions = new ModuleOptions();

        $this->requestParams->expects($this->any())
             ->method('toArray')->will($this->returnValue(array()));

        $createData = new Create($this->request, $di, $moduleOptions);
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

        $this->requestParams->expects($this->any())
             ->method('toArray')->will($this->returnValue(array()));

        $createData = new Create($this->request, $di, $moduleOptions);
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

        $this->requestParams->expects($this->any())
             ->method('toArray')->will($this->returnValue(array($key=>$value)));

        $createData = new Create($this->request, $di, $moduleOptions);

        $this->assertEquals($value, $createData->{"get".ucfirst($key)}());
    }
}
