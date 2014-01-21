<?php
namespace Library\Persistence;

interface IPersistenceManager 
{
    function Get(\Library\Persistence\IPersistenceSearcher $search);
    
    function GetCollection(\Library\Persistence\IPersistenceSearcher $search);
    
    function Add($objectToAdd, array $referenceObjects);
    
    function Change($objectToChange, array $referenceObjects);
    
    function Delete($objectToDelete = null, \Library\Persistence\IPersistenceSearcher $search = null);
    
    function Commit();
}
?>
