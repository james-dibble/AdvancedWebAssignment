<?php
namespace Application\Models\Domain;

abstract class GeographicReference 
{
    public $id;
    public $name;
    
    public abstract function GetTotal();
}
?>
