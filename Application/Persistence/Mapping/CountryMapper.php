<?php
namespace Application\Persistence\Mapping;

class CountryMapper implements \Library\Persistence\IMapper
{
    private $_persistence;
    
    public function __construct(\Library\Persistence\IPersistenceManager $persistence)
    {
        $this->_persistence = $persistence;
    }
    
    public function GetAddQueries($objectToSave, array $referenceObjects)
    {
    }

    public function GetChangeQueries($objectToSave, array $referenceObjects)
    {
        
    }

    public function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher)
    {
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\Country');
    }

    public function MapObject($results)
    {        
    }    
}

?>
