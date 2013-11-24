<?php
namespace Library\Controller;

require_once 'XML/Serializer.php';

class XMLResult implements IActionResult {

    private $_model;

    public function __construct($model) {
        $this->_model = $model;
    }

    public function DoAction() {
        $options = array(
            "indent" => "    ",
            "linebreak" => "\n",
            "typeHints" => false,
            "addDecl" => true,
            "encoding" => "UTF-8",
            "rootName" => strtolower((new \ReflectionClass($this->_model))->getShortName()),
            "defaultTagName" => "item",
            "scalarAsAttributes" => true);

        $serializer = new \XML_Serializer($options);

        if ($serializer->serialize($this->_model)) {
            echo $serializer->getSerializedData();
        }
    }
}
?>
