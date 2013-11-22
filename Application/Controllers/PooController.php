<?php
namespace Application\Controllers;

class PooController extends \Library\Controller\Controller
{
    public function Monkey()
    {
        return new \Library\Controller\ViewResult(new \Application\Views\Poo\Monkey());
    }
}
?>
