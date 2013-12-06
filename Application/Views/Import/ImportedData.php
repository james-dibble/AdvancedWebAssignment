<?php

namespace Application\Views\Import;

class ImportedData extends \Application\Views\Layout\ApplicationLayout implements \Library\Views\IView
{

    private $_stats;

    public function __construct(\DOMDocument $statsAsXml)
    {
        parent::__construct();

        $this->_stats = htmlspecialchars($statsAsXml->saveXML());
        $this->SetTitle('Import - Parsed Data');
    }

    public function BuildView()
    {
        parent::BuildHeader();

        echo <<<HTML
            <div class="row">
                <div class="col-lg-12">
                    <pre>
                        $this->_stats
                    </pre>
                </div>
            </div>
HTML;

        parent::BuildFooter();
    }

}

?>
