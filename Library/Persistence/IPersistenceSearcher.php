<?php
namespace Library\Persistence;

interface IPersistenceSearcher 
{
    function TypeToSearch();
    
    function HasKey($key);
    
    function GetKey($key);
}
?>
