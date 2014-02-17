<?php
namespace Application\Controllers;

class ErrorsController extends \Library\Controller\Controller
{
    public function Index(\Exception $ex)
    {        
        $errorResponse = new \Application\Models\Errors\Response();
        
        $error = new \Application\Models\Errors\Error();
        
        if($ex instanceof \Library\Models\Errors\NotFoundException)
        {
            http_response_code(404);
            $error->code = 404;
        }
        else if($ex instanceof \Library\Models\Errors\UriNotRecognizedException)
        {
            http_response_code(501);
            $error->code = 501;
        }
        else
        {
            http_response_code(500);
            $error->code = 500;
        }
                
        die($ex->getMessage());
        
        $error->desc = $ex->getMessage();
        
        $errorResponse->error = $error;
        
        return $this->XMLResult($errorResponse);
    }
    
    public function NotFound()
    {
        return $this->Index(new \Library\Models\Errors\NotFoundException('Action not found.'));
    }
    
    public function UriUnrecognized()
    {
        return $this->Index(new \Library\Models\Errors\UriNotRecognizedException('URL pattern not recognized.'));
    }
    
    public function Error(\Exception $error)
    {
        return $this->Index($error);
    }
}

?>
