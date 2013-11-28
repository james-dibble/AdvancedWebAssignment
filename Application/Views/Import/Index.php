<?php
namespace Application\Views\Import;

class Index extends \Application\Views\Layout\ApplicationLayout implements \Library\Views\IView 
{
    public function __construct()
    {
        parent::__construct();
        $this->SetTitle('Import');
    }
    
    public function BuildView()
    {
        parent::BuildHeader();
                
        include 'ImportForm.php';
        
        echo '<br /><br />';
        
        include 'ImportFromText.php';
        
        parent::BuildFooter();
    }    
}
?>
