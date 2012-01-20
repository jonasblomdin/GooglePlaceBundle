<?php

namespace Taka512\GooglePlaceBundle\Tests\Servces;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Buzz\Message\Response;

/**
 * Test
 *
 * Test for Google Place search api
 */
class SearchApiTest extends WebTestCase
{
    public static $kernel;

    // {{{ setUp
    public function setUp()
    {
        self::$kernel = static::createKernel();
        self::$kernel->boot();
    }
    // }}}
    // {{{ testSuccessMock
    public function testSuccessMock()
    {
        $mock = $this->getSearchApiMock();
        $c = $mock->createCriteria();
        $c->setLatitude(35.363491);
        $c->setLongitude(138.729856);
        $c->setRadius(10);
        $c->setTypes(array('establishment'));

        $mock->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->getSuccessfulResultRequest()));

        $places = $mock->searchPlaces($c);

        $this->assertEquals(true, $places->getMatches());

        foreach($places->getPlaces() as $place)
        {
            $this->assertEquals(35.363491,  $place->getLatitude());
            $this->assertEquals(138.729856, $place->getLongitude());
            $this->assertEquals('富士山',   $place->getName());
        }

    }
    // }}}
    // {{{ getSuccessfulResultRequest
    protected function getSuccessfulResultRequest()
    {
        $r = new Response();
        $r->setContent(
                json_encode(
                    array(
                        'status'    => 'OK',
                        'results'   => array(
                            array(
                                'geometry'=> array(
                                    'location' => array(
                                        'lat' => 35.363491,
                                        'lng' => 138.729856
                                        )
                                    ),
                                'icon' => 'http://maps.gstatic.com/mapfiles/place_api/icons/generic_business-71.png',
                                'id'   => '88e4d9a219a02d80f6367b6b9dfd737f327775a9',
                                'name' =>  '富士山',
                                'rating' => 4.8,
                                'reference' => 'CmRfAAAAZ8VSfzq0-6tRFwklLFD4_dTUlF-9tTP1VYvnDlpGbKmkt5Ltu7gEnBwL-TZBiokFxGcA2xiC7kIYElpcuyFWbPQ978ZqRNvpkUr1FyVJ3G3QBa3R9QZIqdBEB4428_n9EhC9sTgMYDdkH_mw5eHNPt0MGhTmgQTY9LwLV9PdHIcARdwk5xc3rw',
                                'types' => array(
                                    'establishment'
                                    ),
                                'vicinity' => '静岡県御殿場市中畑2109'
                                )))));
        return $r;
    }
    // }}}
    // {{{ testNoMatchMock
    public function testNoMatchMock()
    {
        $mock = $this->getSearchApiMock();
        $c = $mock->createCriteria();
        $c->setLatitude(1.1234);
        $c->setLongitude(1.1234);
        $c->setRadius(10);
        $c->setTypes(array('establishment'));

        $mock->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->getNoMatchResultRequest()));

        $places = $mock->searchPlaces($c);

        $this->assertEquals(false, $places->getMatches());

    }
    // }}}
    // {{{ getNoMatchResultRequest
    protected function getNoMatchResultRequest()
    {
        $r = new Response();
        $r->setContent(
                json_encode(
                    array(
                        'status'    => 'ZERO_RESULTS',
                        'results'   => array())));
        return $r;
    }
    // }}}
    // {{{ getSearchApiMock
    protected function getSearchApiMock()
    {
        return $this->getMock('Taka512\GooglePlaceBundle\Services\SearchApi',
                array('request'),
                array(
                    'test',
                    self::$kernel->getContainer()->get('validator'),
                    self::$kernel->getContainer()->get('logger'),
                    'Taka512\GooglePlaceBundle\Model\SearchCriteria',
                    ));
    }
    // }}}
}
