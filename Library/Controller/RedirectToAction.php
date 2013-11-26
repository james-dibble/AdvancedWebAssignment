<?php
namespace Library\Controller;

class RedirectToAction implements \Library\Controller\IActionResult
{
    private $_newAction;
    
    public function __construct($action)
    {
        $this->_newAction = $action;
    }
    
    public function DoAction()
    {
        header(CONTEXT_PATH . $this->_newAction);
    }    
}

?>
