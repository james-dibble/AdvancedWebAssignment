<?php
namespace Library\Controller;

require_once 'XML/Serializer.php';

class XMLResult implements IActionResult {

    private $_model;

    public function __construct($model) {
        $this->_model = $model;
    }

    public function DoAction() {
        $asXml = \Library\Persistence\XMLSerialiser::Serialise($this->_model);
        
        echo $asXml->saveXML();
    }
}
?>
