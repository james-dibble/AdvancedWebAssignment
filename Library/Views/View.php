<?php
namespace Library\Views;

abstract class View implements \Library\Views\IView
{
    public abstract function BuildView();    
    
    protected function PartialView($path)
    {
        include dirname(__FILE__) . '/../../' . $path;
    }
}
?>
