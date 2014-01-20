<?php
namespace Library\Persistence;

interface IMapperDictionary
{
    function Add(\Library\Persistence\IMapper $mapper);
    
    function GetMapper(\ReflectionClass $class);
}
?>
