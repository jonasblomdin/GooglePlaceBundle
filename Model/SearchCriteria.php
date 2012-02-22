<?php

namespace Taka512\GooglePlaceBundle\Model;

/**
 * API search request criteria
 *
 * @author taka512
 *
 */
class SearchCriteria implements GetCriteriaInterface
{
    // {{{ const
    const TYPES_DELIMITER = '|';
    // }}}
    // {{{ properties
    /**
     * @var string $apiKey
     */
    protected $apiKey = null;

    /**
     * @var decimal $latitude
     */
    protected $latitude = null;

    /**
     * @var decimal $longitude
     */
    protected $longitude = null;

    /**
     * @var integer $radius
     */
    protected $radius = 500;

    /**
     * @var array $types
     */
    protected $types = null;

    /**
     * @var string $language
     */
    protected $language = 'ja';

    /**
     * @var string $sensor
     */
    protected $sensor = 'false';

    /**
     * @var string $keyword
     */
    protected $keyword = null;

    /**
     * @var string $keyword
     */
    protected $name = null;

    // }}}
    // {{{ getter setter

    /**
     * Set apiKey
     *
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Get apiKey
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set latitude
     *
     * @param decimal $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Get latitude
     *
     * @return decimal
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param decimal $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get longitude
     *
     * @return decimal
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set radius
     *
     * @param integer $radius
     */
    public function setRadius($radius)
    {
        $this->radius = $radius;
    }

    /**
     * Get radius
     *
     * @return integer
     */
    public function getRadius()
    {
        return $this->radius;
    }
    /**
     * Set types
     *
     * @param string $types
     */
    public function setTypes($types)
    {
        $this->types = $types;
    }

    /**
     * Get types
     *
     * @return string
     */
    public function getTypes()
    {

        return $this->types;
    }
    /**
     * Set types
     *
     * @param array $types
     */
    public function setTypesByArray($types)
    {
        $this->types =  implode(self::TYPES_DELIMITER, $types);
    }

    /**
     * Get types
     *
     * @return array
     */
    public function getTypesArray()
    {

        return explode(self::TYPES_DELIMITER, $this->types);
    }

    /**
     * Set language
     *
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set sensor
     *
     * @param string $sensor
     */
    public function setSensor($sensor)
    {
        $this->sensor = $sensor;
    }

    /**
     * Get sensor
     *
     * @return string
     */
    public function getSensor()
    {
        return $this->sensor;
    }

    /**
     * Set keyword
     *
     * @param string $keyword
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * Get keyword
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    // }}}
    // {{{ buildQuery
    /**
     * build Search Request Query Parameter
     *
     * @return string
     */
    public function buildQuery()
    {
        $param = array();
        $param['location'] = sprintf('%s,%s', $this->getLatitude(), $this->getLongitude());
        $param['radius']   = $this->getRadius();
        $param['sensor']   = $this->getSensor();
        $param['key']      = $this->getApiKey();

        foreach(array('types','language','name', 'keyword') as $name)
        {
            if(!\is_null($this->$name))
                $param[$name] = $this->$name;
        }

        return \http_build_query($param);
    }

    // }}}
}
