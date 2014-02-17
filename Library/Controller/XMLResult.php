<?php
namespace Library\Controller;

class XMLResult implements IActionResult 
{
    private $_model;
    private $_schema;

    public function __construct($model, $schema = false) 
    {
        $this->_model = $model;
        $this->_schema = $schema;
    }

    public function DoAction() 
    {
        header('Content-type: text/xml');
        
        $asXml = \Library\Persistence\XMLSerialiser::Serialise($this->_model, false, $this->_schema);
        
        echo $asXml->saveXML();
    }
}
?>
