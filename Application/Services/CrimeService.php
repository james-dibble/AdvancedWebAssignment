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
        foreach ($crimeStatistics->nationals as $national)
        {
            $this->SaveNewNational($national);
        }
        
        foreach ($crimeStatistics->countires as $country)
        {
            $this->SaveNewCountry($country);
        }
    }

    public function SaveArea(\Application\Models\Domain\Area $area, \Application\Models\Domain\Region $region)
    {
        $existingArea = $this->GetArea($area->name);
        
        // Areas should be persisted idempotently, so remove any existsing area
        // with the same name and overwrite it.
        if($existingArea != null)
        {
            $this->DeleteArea($existingArea);
        }
        
        $area->region = $region;

        $this->_persistence->Add($area, array());
        
        $this->_persistence->Commit();
                
        $savedArea = $this->_persistence->Get(new \Library\Persistence\PersistenceSearcher(
                            new \ReflectionClass('\Application\Models\Domain\Area'), array('ByName' => $area->name)));
        
        $statisticTypes = $this->GetAllCrimeTypes();
            
        // Add any missing statistics to the area so it has a 0 value.
        foreach($statisticTypes as $type)
        {
            if(!$area->HasStatistic($type))
            {
                $this->_persistence->Add(new \Application\Models\Domain\CrimeStatistic(0, $type, $savedArea), array('area' => $savedArea));
            }
        }
        
        foreach($area->crimeStatistics as $statistic)
        {
            $this->_persistence->Add($statistic, array('area' => $savedArea));
        }
        
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
    
    private function SaveNewArea($area, $region)
    {
        $area->region = $region;

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
    
    private function SaveNewRegion($region, $country)
    {
        $region->country = $country;

        $this->_persistence->Add($region, array());

        $this->_persistence->Commit();

        $savedRegion = $this->_persistence->Get(new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('\Application\Models\Domain\Region'), array('ByName' => $region->name)));

        foreach ($region->areas as $area)
        {
            $this->SaveNewArea($area, $savedRegion);
        }
    }
    
    private function SaveNewCountry($country)
    {
        $this->_persistence->Add($country, array());

        $this->_persistence->Commit();

        $savedCountry = $this->_persistence->Get(new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('\Application\Models\Domain\Country'), array('ByName' => $country->name)));

        foreach ($country->regions as $region)
        {
            $this->SaveNewRegion($region, $savedCountry);
        }
    }
    
    private function SaveNewNational($national)
    {
        $this->_persistence->Add($national, array());

        $this->_persistence->Commit();

        $savedNational = $this->_persistence->Get(new \Library\Persistence\PersistenceSearcher(
                new \ReflectionClass('\Application\Models\Domain\National'), array('ByName' => $national->name)));

        foreach ($national->crimeStatistics as $crimeStatistic)
        {
            $this->_persistence->Add($crimeStatistic, array('area' => $savedNational));
        }

        $this->_persistence->Commit();
    }
}
?>