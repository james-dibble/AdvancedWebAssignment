<?php
namespace Library\Persistence;

interface IMapper
{
    function GetMappedClass();
            
    function GetAddQueries($objectToSave);
    
    function GetChangeQueries($objectToSave);
    
    function GetFindQuery(\Library\Persistence\IPersistenceSearcher $searcher);
    
    function MapObject
}
?>