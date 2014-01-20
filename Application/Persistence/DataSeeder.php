<?php
namespace Application\Persistence;
class DataSeeder 
{
    static function ClearAndSeed(\Library\Persistence\IPersistenceManager $persistence)
    {
        $persistence->Delete(
                null, 
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\CrimeStatistic'), 
                        array('Clear' => null)));
        
        $persistence->Delete(
                null, 
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\CrimeStatisticType'), 
                        array('Clear' => null)));
        
        $persistence->Delete(
                null, 
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\Area'), 
                        array('Clear' => null)));
        
        $persistence->Delete(
                null, 
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\National'), 
                        array('Clear' => null)));
        
        $persistence->Delete(
                null, 
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\Region'), 
                        array('Clear' => null)));
        
        $persistence->Delete(
                null, 
                new \Library\Persistence\PersistenceSearcher(
                        new \ReflectionClass('\Application\Models\Domain\Country'), 
                        array('Clear' => null)));
    }
}
?>