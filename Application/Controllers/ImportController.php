<?php
namespace Application\Controllers;

class ImportController extends \Library\Controller\Controller
{
    public function Index()
    {
        return new \Library\Controller\ViewResult(new \Application\Views\Import\Index());
    }
    
    public function File()
    {
        return new \Library\Controller\RedirectToAction('import');
    }
}

?>
