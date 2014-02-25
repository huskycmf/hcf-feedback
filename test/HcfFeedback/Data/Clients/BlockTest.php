<?php
namespace HcbClientTest\Data\Clients;

use HcbClient\Entity\User as ClientEntity;
use Zend\Stdlib\Parameters;

class BlockTest extends \PHPUnit_Framework_TestCase
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
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $idsCollection;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $translator;

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

        $this->idsCollection = $this->getMock('\HcbClient\Service\Collection\IdsService',
                                              array('fetch'), array(), '', false);

        $this->translator = $this->getMock('\Zend\I18n\Translator\Translator');
        $this->translator->expects($this->any())->method('translate')->will($this->returnArgument(0));
    }

    /**
     * @return array
     */
    public function clientsProvider()
    {
        return array(array(array(new ClientEntity(), new ClientEntity(), new ClientEntity()),
                           array(new ClientEntity())));
    }

    /**
     * @dataProvider clientsProvider
     * @param array $expectedClients
     */
    public function testClientsExtractedFromPost(array $expectedClients)
    {
        $this->requestParams->expects($this->any())
                      ->method('toArray')
                      ->will($this->returnValue(array('clients'=>array(1,2,3))));

        $this->idsCollection->expects($this->any())
                      ->method('fetch')
                      ->will($this->returnValue($expectedClients));

        $block = new Block($this->request, $this->idsCollection, $this->translator);

        $this->assertTrue($block->isValid());
        $this->assertEquals($expectedClients, $block->getClients());
    }

    public function testNotFoundClientsError()
    {
        $this->requestParams->expects($this->any())
            ->method('toArray')
            ->will($this->returnValue(array('clients'=>array(1,2,3))));

        $this->idsCollection->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(array()));

        $block = new Block($this->request, $this->idsCollection, $this->translator);

        $this->assertFalse($block->isValid());
        $this->assertEquals(array(), $block->getClients());
        $messages = $block->getMessages();
        $this->assertInternalType('array', $messages);
        $this->assertArrayHasKey('clients', $messages);
    }
}
