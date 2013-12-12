<?php
namespace Application\Views\Documentation;

class Index extends \Application\Views\Layout\ApplicationLayout implements \Library\Views\IView
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

        echo '<pre>' . show_source($this->_filePathToOutput) . '</pre>';

        $this->BuildFooter();
    }    
}
?>