<?php
namespace Library\Routing;

class RequestContext
{
    private $_controller;
    private $_action;
    private $_parameters;

    function __construct($controller, $action, $parameters)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_parameters = $parameters;
    }
    
    function GetController()
    {
        return $this->_controller;
    }
        
    function GetAction()
    {
        return $this->_action;
    }
    
    function GetParameters()
    {
        return $this->_parameters;
    }
}
?>
