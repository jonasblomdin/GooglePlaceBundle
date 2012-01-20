# Google Place Bundle for Symfony2

## Overview

A Symfony 2 bundle for the
[Google Place API](http://code.google.com/intl/en/apis/maps/documentation/places/)
service

## Requirements

 * PHP 5.3+

## Dependancies

 * [Buzz](https://github.com/kriswallsmith/Buzz)

## Installation

1. Add bundle and Buzz library dependancy to `vendor` dir:

    * Using vendors script

        Add the following to the `deps` file:

            [Buzz]
                git=git://github.com/kriswallsmith/Buzz.git
                target=/Buzz

            [Taka512GooglePlaceBundle]
                git=git://github.com/taka512/GooglePlaceBundle.git
                target=/bundles/Taka512/GooglePlaceBundle

        Run the vendors script:

            $ php bin/vendors install

2. Add the Google and Network namespace to your autoloader:

        // app/autoload.php
        $loader->registerNamespaces(array(
            // ..
            'Buzz'      => __DIR__.'/../vendor/Buzz/lib',
            'Taka512'   => __DIR__.'/../vendor/bundles',
        ));

3. Add bundle to application kernel:

        // app/ApplicationKernel.php
        public function registerBundles()
        {
            return array(
                // ...
                new Taka512\GooglePlaceBundle\Taka512GooglePlaceBundle(),
            );
        }

4. Add config 

        // app/config/config.yml
        taka512_google_place:
            api_key: 'xxxxxx'


## Usage

The bundle provides a service available via the ``taka512_google_place.search_api``
identifier.

To retrieve the service from the container:

    $geo = $this->get('taka512_google_place.search_api');

### Basic usage

To find places

    $searchApi = $this->get('taka512_google_place.search_api');
    $c = $searchApi->createCriteria();
    $c->setLatitude(35.675888);
    $c->setLongitude(139.7448576);
    $c->setTypes(array('convenience_store'));
    $places = $placeApi->searchPlaces($c);

    if($places->isSuccess())
    {
        foreach($places->getPlaces() as $place)
        {
            $lat = $place->getLatitude();
            $lng = $place->getLongitude();
        }
    }


## TODO

  * Place Details
  * Place Check-Ins
  * User Place Reports
  * Caching

