<?php
namespace Library\Composition;

interface IContainer 
{
    function Resolve($binding);
    
    function ResolveAll($binding);
    
    function Bind($binding, $object);
}
?>
