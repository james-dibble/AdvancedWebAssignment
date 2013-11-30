<?php
namespace Application\Persistence\Mapping;

class AreaMapper implements \Library\Persistence\IMapper
{
    public function GetAddQueries($objectToSave)
    {
        
    }

    public function GetChangeQueries($objectToSave)
    {
        
    }

    public function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher)
    {
        if($searcher->HasKey('ForRegion'))
        {
            return sprintf('GetAreasForRegion(%d)', $searcher->GetKey('ForRegion'));
        }
    }

    public function GetMappedClass()
    {
        return new \ReflectionClass('\Application\Models\Domain\Area');
    }

    public function MapObject($results)
    {
        $mappedObject = new \Application\Models\Domain\Area();
        
        $mappedObject->id = $results['name'];
        $mappedObject->homocide = $results['Homicide'];
        $mappedObject->violenceWithInjury['ViolenceWithInjury'];
        
        return $mappedObject;
    }    
}

?>
