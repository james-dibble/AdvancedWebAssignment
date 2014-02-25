<?php

namespace Application\Views\Import;

class ImportedData extends \Application\Views\Layout\ApplicationLayout implements \Library\Views\IView
{
    private $_stats;

    public function __construct(\DOMDocument $statsAsXml)
    {
        parent::__construct();

        $this->_stats = $statsAsXml;
        $this->SetTitle('Import - Parsed Data');
    }

    public function BuildView()
    {
        parent::BuildHeader();

        include 'Index/Index.php';
        
        $xmlDataPartial = new \Application\Views\Import\XMLData($this->_stats);
        $xmlDataPartial->BuildView();

        parent::BuildFooter();
    }

}

?>
