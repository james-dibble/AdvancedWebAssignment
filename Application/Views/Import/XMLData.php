<?php

namespace Application\Views\Import;

class XMLData implements \Library\Views\IView
{
    private $_model;

    public function __construct(\DOMDocument $model)
    {
        $this->_model = $model;
    }

    public function BuildView()
    {
        $tempDomDocument = new \DOMDocument;
        $tempDomDocument->loadXML($this->_model->saveXML());
        $validationResult = $tempDomDocument->schemaValidate('CrimeRecord.xsd');
		
        if ($validationResult)
        {
            include 'ImportedData/ValidationSuccess.php';
        }
        else
        {
            include 'ImportedData/ValidationFailure.php';
        }
		
        echo '<div class="row">&nbsp;</div>';

        echo '<div class="row">&nbsp;</div>';
		
        echo '<pre>';
        echo htmlspecialchars($this->_model->saveXML());
        echo '</pre>';
    }

}

?>
