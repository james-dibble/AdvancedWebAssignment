<?php
namespace Application\Models\Domain;

abstract class GeographicReference 
{
    public $id;
    
    public abstract function GetTotal();
}
?>
