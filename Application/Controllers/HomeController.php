<?php
namespace Application\Controllers;

class HomeController extends \Library\Controller\Controller
{
    public function Index()
    {
        return $this->ViewResult(new \Application\Views\Home\Index());
    }
}
?>
