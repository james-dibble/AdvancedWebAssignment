<?php
namespace Application\Views\Import;

class Index extends \Application\Views\Layout\ApplicationLayout implements \Library\Views\IView 
{
    public function __construct()
    {
        parent::__construct();
        $this->SetTitle('Import');
    }
    
    public function BuildView($model)
    {
        parent::BuildHeader();
                
        include 'Index/Index.php';
        
        parent::BuildFooter();
    }    
}
?>
