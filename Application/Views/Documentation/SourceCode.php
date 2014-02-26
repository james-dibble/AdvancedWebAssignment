<?php

namespace Application\Views\Documentation;

class SourceCode extends \Application\Views\Layout\ApplicationLayout implements \Library\Views\IView
{

    private $_filePathToOutput;

    public function __construct($filePathToOutput)
    {
        parent::__construct();
        $this->SetTitle('Advanced Topics in Web Development - James Dibble 10009689');
        $this->SetDescription('Advanced Topics in Web Development - James Dibble 10009689');

        $this->_filePathToOutput = $filePathToOutput;
    }

    public function BuildView()
    {
        $this->BuildHeader();
        
        $source = show_source(dirname(__FILE__) . '/../../../' . $this->_filePathToOutput, true);
        $source = str_replace('<code>', '', str_replace('<br />', '</li><li>', $source));
        
        $backToSourceLink = CONTEXT_PATH . 'crimes/doc/index.html#code';
        
        echo <<<HTML
        <h2>$this->_filePathToOutput<br /> <a href="$backToSourceLink">Back To Source</a></h2>
                <pre>
                <ol>
                <li>
                $source
                </ol>
                </pre>
HTML;

        $this->BuildFooter();
    }

}

?>