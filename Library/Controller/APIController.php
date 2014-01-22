<?php
namespace Library\Controller;

class APIController extends \Library\Controller\Controller
{
    protected function BuildRespose($model, $format)
    {
        if(strtolower($format) === 'xml')
        {
            return $this->XmlResult($model);
        }
        
        if(strtolower($format) === 'json')
        {
            return $this->JsonResult($model);
        }
        
        return null;
    }
}
?>
