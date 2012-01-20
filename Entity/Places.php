<?php

namespace Taka512\GooglePlaceBundle\Entity;

use Taka512\GooglePlaceBundle\Entity\Place;

/**
 * Google Place Search Result
 */
class Places
{
    // {{{ properties
    /**
     * @var boolean
     */
    protected $matches = false;

    /**
     * @var integer
     */
    protected $status;

    /**
     * @var string
     */
    protected $result;

    /**
     * @var array
     */
    protected $places = array();

    // }}}
    // {{{ getter setter
    /**
     * Set matches
     *
     * @param integer $matches

     */
    public function setMatches($matches)
    {
        $this->matches = $matches;
    }

    /**
     * Get matches
     *
     * @return integer
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * Set result
     *
     * @param string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set places
     *
     * @param array $results
     */
    public function setPlaces(array $results)
    {

        foreach($results as $result)
        {
            $place = new Place();
            $place->setLatitude($result['geometry']['location']['lat']);
            $place->setLongitude($result['geometry']['location']['lng']);
            $place->setIcon($result['icon']);
            $place->setGooglePlaceId($result['id']);
            $place->setName($result['name']);
            $place->setReference($result['reference']);
            $place->setTypes($result['types']);
            $place->setVicinity($result['vicinity']);
            if(array_key_exists('rating', $result))
                $place->setRating($result['rating']);

            $this->places[] = $place;
        }
    }

    /**
     * Get places
     *
     * @return array
     */
    public function getPlaces()
    {
        return $this->places;
    }
    // }}}
    // {{{ isSuccess
    /**
     * search request result
     *
     * @return  boolean
     */
    public function isSuccess()
    {
        if ($this->getStatus() === 'OK')
            return true;

        return false;
    }
    // }}}
}
