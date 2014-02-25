<?php
namespace Library\Controller;

class XMLResult implements IActionResult 
{
    private $_model;

    public function __construct($model) 
    {
        $this->_model = $model;
    }

    public function DoAction() 
    {
        header('Content-type: text/xml');
        
        $asXml = \Library\Persistence\XMLSerialiser::Serialise($this->_model);
        
        echo $asXml->saveXML();
    }
}
?>
