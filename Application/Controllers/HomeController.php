<?php
namespace Application\Controllers;

class HomeController extends \Library\Controller\Controller
{
    public function Index()
    {
        return new \Library\Controller\ViewResult(new \Application\Views\Home\Index());
    }
}
?>
