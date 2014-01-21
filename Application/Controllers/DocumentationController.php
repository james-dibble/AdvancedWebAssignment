<?php
namespace Application\Controllers;

class DocumentationController extends \Library\Controller\Controller
{
    public function Index()
    {
        return $this->ViewResult(new \Application\Views\Documentation\Index());
    }
    
    public function Source($path)
    {
        return $this->ViewResult(new \Application\Views\Documentation\SourceCode($path));
    }
}
?>