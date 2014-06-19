<?php

namespace Taka512\GooglePlaceBundle\Services;

use Taka512\GooglePlaceBundle\Entity\Places;
use Taka512\GooglePlaceBundle\Model\GetCriteriaInterface;

use Symfony\Component\Validator\Validator\LegacyValidator as Validator;
use Symfony\Bridge\Monolog\Logger;
use Buzz\Browser;

/**
 * SearchApi
 *
 * Provides a simple wrapper around Google Place API.
 *
 * @link http://code.google.com/intl/en/apis/maps/documentation/places/
 */
class SearchApi
{
    // {{{ properties 
    /**
     * Network layer
     *
     * @var Buzz\Browser
     */
    protected $browser;

    /**
     * Google Place Api Key
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Google Place Api Key
     *
     * @var Symfony\Component\Validator\Validator
     */
    protected $validator;

    /**
     * Google Place Api Key
     *
     * @var Symfony\Bridge\Monolog\Logger
     */
    protected $logger;

    /**
     * Search Criteria class
     *
     * @var string
     */
    protected $criteria;
    // }}} 
    // {{{ __construct
    /**
     * Set Network layer
     *
     * @param string    $apiKey         google place api key
     * @param Validator $validator      validater service
     * @param Logger    $logger         logger service
     * @param string    $criteria       search criteria class
     * @param Browser   $browser        browser
     */
    public function __construct($apiKey, Validator $validator, Logger $logger, $criteria, Browser $browser = null)
    {
        $this->browser = $browser ?: new Browser();

        $this->apiKey         = $apiKey;
        $this->validator      = $validator;
        $this->logger         = $logger;
        $this->criteria       = $criteria;
    }
    // }}}
    // {{{ setBrowser
    /**
     * Set Network layer
     *
     * @param Browser   $browser        Browser
     */
    public function setBrowser(Browser $browser)
    {
        $this->browser = $browser;
    }
    // }}}
    // {{{ createCriteria
    /**
     * Create search Criteria
     *
     * @return Criteria
     */
    public function createCriteria()
    {
        $class = $this->criteria;
        return new $class;
    }
    // }}}
    // {{{ searchPlaces
    /**
     * search place and populate Place entity with result
     *
     * @param   GetCriteriaInterface $c
     * @return  Places 
     */
    public function searchPlaces(GetCriteriaInterface $c)
    {
        $this->setSearchParametersForCriteria($c);

        $response   = $this->request($c);

        $data       = json_decode($response->getContent(), true);

        $places = new Places();
        $places->setResult($response->getContent());
        $places->setStatus($data['status']);

        if ($places->isSuccess())
        {
            $places->setPlaces($data['results']);
            $places->setMatches(true);
        }else{
            $places->setMatches(false);
        }
        return $places;
    }
    // }}}
    // {{{ setSearchParametersForCriteria
    /**
     */
    protected function setSearchParametersForCriteria($c)
    {
        $c->setApiKey($this->apiKey);
    }
    // }}}
    // {{{ request
    /**
     * Search request by Criteria
     *
     * @return  array  response from web service
     */
    protected function request(GetCriteriaInterface $c)
    {
        return $this->browser->get('https://maps.googleapis.com/maps/api/place/search/json?' . $c->buildQuery());
    }
    // }}}
}


