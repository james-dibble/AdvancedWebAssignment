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
        ob_clean();
        header_remove();
        
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        
        header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . CONTEXT_PATH . $this->_newAction, true, 302);
        ob_end_flush();
    }    
}

?>
