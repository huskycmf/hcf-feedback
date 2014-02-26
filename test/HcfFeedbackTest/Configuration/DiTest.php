<?php
namespace HcfFeedbackTest\Configuration;

use Zend\Di\Config;
use Zend\Di\Di;
use Zend\Stdlib\Parameters;

class DiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Di
     */
    protected $di;

    public function setUp()
    {
        $config = new Config(array_merge_recursive(include __DIR__ . '/../../../config/module/di.config.php',
                           include __DIR__.'/../../../vendor/huskycms/hc-core/config/module/di.config.php'));

        $this->di = new Di(null, null, $config);
    }

    public function testControllerCreate()
    {
        $this->assertInstanceOf('HcCore\Controller\Common\Rest\Collection\DataController',
                                $this->di->get('HcfFeedback-Controller-Create'));
    }

    public function testMailPersister()
    {
        $this->assertInstanceOf('HcfFeedback\Service\Persister\MailPersister',
                                $this->di->get('HcfFeedback-Service-Persister-Mail'));
    }

    public function testAggregatePersister()
    {
        $this->assertInstanceOf('HcfFeedback\Service\Persister\AggregatePersister',
                                $this->di->get('HcfFeedback-Service-Aggregate-Persister'));
    }
}
