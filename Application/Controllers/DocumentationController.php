<?php
namespace Application\Controllers;

class DocumentationController extends \Library\Controller\Controller
{
    public function Index()
    {
        return new \Library\Controller\ViewResult(new \Application\Views\Documentation\Index());
    }
    
    public function Source($path)
    {
        return new \Library\Controller\ViewResult(new \Application\Views\Documentation\SourceCode($path));
    }
}
?>