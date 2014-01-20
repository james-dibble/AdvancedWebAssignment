<?php
namespace Application\Views\Import;

class ErrorUploading extends \Application\Views\Layout\ApplicationLayout implements \Library\Views\IView 
{
    public function __construct()
    {
        parent::__construct();
        $this->SetTitle('Import - Error');
    }
    
    public function BuildView()
    {
        parent::BuildHeader();
                
        include 'ErrorUploading/WarningMessage.php';
        
        parent::BuildFooter();
    }  
}

?>
