<?php

namespace Application\Services;

class LocationService implements \Application\Services\ILocationService {

    private $_persitence;

    public function __construct(\Library\Persistence\IPersistenceManager $persistence) {
        $this->_persitence = $persistence;
    }

    public function GetAllRegions() {
        $regions = $this->_persitence->GetCollection(
                new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('Application\Models\Domain\Region'), array()));

        return $regions;
    }

    public function GetAllCountries() {
        $countries = $this->_persitence->GetCollection(
                new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('Application\Models\Domain\Country'), array()));

        return $countries;
    }

    public function GetCountryForRegion(\Application\Models\Domain\Region $region) {
        $country = $this->_persitence->Get(
                new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('Application\Models\Domain\Country'), array('ForRegion' => $region)));
        
        return $country;
    }

}

?>