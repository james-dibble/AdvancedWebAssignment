<?php
namespace Library\Persistence;

interface IMapper
{
    function GetMappedClass();
            
    function GetAddQueries($objectToSave, array $refernceObjects);
    
    function GetChangeQueries($objectToSave, array $referenceObjects);
    
    function GetDeleteQueries($objectToSave = null, \Library\Persistence\IPersistenceSearcher $searcher = null);
    
    function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher);
    
    function MapObject($results, \Library\Persistence\IPersistenceSearcher $searcher);
}
?>