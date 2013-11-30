<?php
namespace Application\Persistence\Mapping;

class CountryMapper implements \Library\Persistence\IMapper
{
    public function GetAddQueries($objectToSave)
    {
        
    }

    public function GetChangeQueries($objectToSave)
    {
        
    }

    public function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher)
    {
        return 'GetAllCountries()';
    }

    public function GetMappedClass()
    {
        
    }

    public function MapObject($results)
    {
        
    }    
}

?>
