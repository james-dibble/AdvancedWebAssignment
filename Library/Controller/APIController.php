<?php
namespace Library\Controller;

class APIController extends \Library\Controller\Controller
{
    protected static function BuildRespose($model, $format)
    {
        if(strtolower($format) === 'xml')
        {
            return new \Library\Controller\XMLResult($model);
        }
        
        if(strtolower($format) === 'json')
        {
            return new \Library\Controller\JsonResult($model);
        }
        
        return null;
    }
}
?>
