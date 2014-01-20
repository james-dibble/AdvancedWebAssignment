<?php

namespace Application\Persistence\Mapping;

class NationalMapper implements \Library\Persistence\IMapper
{

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
        return new \ReflectionClass('\Application\Models\Domain\National');
    }

    public function MapObject($results)
    {
    }
}
?>