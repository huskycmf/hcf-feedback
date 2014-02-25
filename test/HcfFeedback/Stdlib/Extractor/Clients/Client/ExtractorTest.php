<?php
namespace HcbClientTest\Stdlib\Extractor\Clients\Client;

use HcbClient\Entity\User as ClientEntity;
use HcbClient\Stdlib\Extractor\Client;

class ExtractorTest extends \PHPUnit_Framework_TestCase
{
    public function testExtract()
    {
        $client = new ClientEntity();

        $client->setEmail('herr@herr.com');
        $client->setUsername('Test');
        $client->setState(12);

        $extractor = new Client();
        $result = $extractor->extract($client);
        $this->assertEquals(array('id'=>'',
                                  'username'=>'Test',
                                  'email'=>'herr@herr.com',
                                  'state'=>12),
                            $result);
    }

    public function testExtractException()
    {
        $client = new \stdClass();

        $extractor = new Extractor();
        $this->setExpectedException('InvalidArgumentException');

        $extractor->extract($client);
    }
}
