<?php

namespace Application\Services;

class CrimeService implements ICrimeService
{
    private $_persistence;
    private $_cache;

    public function __construct(\Library\Persistence\IPersistenceManager $persistence, \Library\Caching\IRequestCache $cache)
    {
        $this->_persistence = $persistence;
        $this->_cache = $cache;
    }

    public function GetCrimesForAllRegions($year)
    {
        $crimes =
                $this->_persistence->GetCollection(
                new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('\Application\Models\Domain\Region'), array()));

        return $crimes;
    }

    public function GetCrimesForRegion($year, $region)
    {
        $region =
                $this->_persistence->Get(
                new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('\Application\Models\Domain\Region'), array('ByName' => $region)));

        return $region;
    }

    public function GetCrimesForAllNationalStatistics($year)
    {
        $crimes =
                $this->_persistence->GetCollection(
                new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('\Application\Models\Domain\National'), array()));

        return $crimes;
    }

    public function GetCrimesForCountry($year, $country)
    {
        $country =
                $this->_persistence->Get(
                new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('\Application\Models\Domain\Country'), array('ById' => $country)));

        return $country;
    }

    public function SaveStatistics(\Application\Models\Domain\StatisticsCollection $crimeStatistics)
    {
        foreach ($crimeStatistics->countires as $country)
        {
            $this->_persistence->Add($country, array());

            $this->_persistence->Commit();

            $savedCountry = $this->_persistence->Get(new \Library\Persistence\PersistenceSearcher(
                    new \ReflectionClass('\Application\Models\Domain\Country'), array('ByName' => $country->name)));

            foreach ($country->regions as $region)
            {
                $region->country = $savedCountry;

                $this->_persistence->Add($region, array());

                $this->_persistence->Commit();

                $savedRegion = $this->_persistence->Get(new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\Region'), array('ByName' => $region->name)));

                foreach ($region->areas as $area)
                {
                    $area->region = $savedRegion;

                    $this->_persistence->Add($area, array());

                    $this->_persistence->Commit();

                    $savedArea = $this->_persistence->Get(new \Library\Persistence\PersistenceSearcher(
                            new \ReflectionClass('\Application\Models\Domain\Area'), array('ByName' => $area->name)));

                    foreach ($area->crimeStatistics as $crimeStatistic)
                    {
                        $this->_persistence->Add($crimeStatistic, array('area' => $savedArea));
                    }

                    $this->_persistence->Commit();
                }
            }
        }
    }

    public function SaveArea(\Application\Models\Domain\Area $area, \Application\Models\Domain\Region $region)
    {
        $area->region = $region;

        $this->_persistence->Add($area, array());

        $this->_persistence->Commit();
        
        $this->_cache->EmptyCache();
    }

    public function ClearCrimes()
    {
        $this->_cache->EmptyCache();
        
        \Application\Persistence\DataSeeder::ClearAndSeed($this->_persistence);
    }

    public function GetAllCrimeTypes()
    {
        $crimeTypes = $this->_persistence->GetCollection(
                new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('\Application\Models\Domain\CrimeStatisticType'), array()));

        return $crimeTypes;
    }

    public function GetCrimeType($abbreviation)
    {
        $crimeTypes = $this->_persistence->Get(
                new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('\Application\Models\Domain\CrimeStatisticType'), array('abbreviation' => $abbreviation)));

        return $crimeTypes;
    }

    public function GetArea($areaName)
    {
        $area = $this->_persistence->Get(
                new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('\Application\Models\Domain\Area'), array('ByName' => $areaName)));

        return $area;
    }

    public function DeleteArea(\Application\Models\Domain\Area $area)
    {
        $this->_persistence->Delete($area);

        $this->_persistence->Commit();
        
        $this->_cache->EmptyCache();
    }

    public function ChangeStatistics(array $statistics)
    {
        foreach ($statistics as $statistic)
        {
            $this->_persistence->Change($statistic, array());
        }

        $this->_persistence->Commit();
                
        $this->_cache->EmptyCache();
    }
}
?>