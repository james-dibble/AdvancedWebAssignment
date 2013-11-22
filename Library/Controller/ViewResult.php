<?php
namespace Library\Controller;

class ViewResult implements IActionResult
{
    private $_view;
    
    public function __construct(\Library\Views\IView $view) 
    {
        $this->_view = $view;
    }

    public function DoAction() 
    {    
        $this->_view->BuildView();
    }    
}
?>
