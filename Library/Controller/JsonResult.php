<?php
namespace Library\Controller;

class JsonResult implements IActionResult
{
    private $_model;
    
    public function __construct($model) 
    {
        $this->_model = $model;
    }

    public function DoAction() 
    {
        header('Content-type: application/json');
        
        $asJson = json_encode($this->_model);
        
        echo $asJson;
    }    
}
?>
