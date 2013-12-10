<?php
namespace Library\Persistence;

interface IMapper
{
    function GetMappedClass();
            
    function GetAddQueries($objectToSave, array $refernceObjects);
    
    function GetChangeQueries($objectToSave, array $referenceObjects);
    
    function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher);
    
    function MapObject($results);
}
?>