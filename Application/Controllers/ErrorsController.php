<?php
namespace Application\Controllers;

class ErrorsController extends \Library\Controller\Controller
{
    public function Index(\Exception $ex)
    {
        $errorResponse = new \Application\Models\Error();
        $errorResponse->code = 500;
        $errorResponse->desc = $ex->getMessage();
        
        return new \Library\Controller\XmlResult($errorResponse);
    }
}

?>
