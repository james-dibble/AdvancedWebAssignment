<?php
namespace Application\Controllers;

class ClientController extends \Library\Controller\Controller
{
    public function Index()
    {
        return $this->ViewResult(new \Application\Views\Client\Index());
    }
}
?>