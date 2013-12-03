<?php
namespace Application\Views\Home;

class Index extends \Application\Views\Layout\ApplicationLayout implements \Library\Views\IView 
{
    public function __construct()
    {
        parent::__construct();
        $this->SetTitle('Home');
        $this->SetDescription('Home');
        
        $this->AddScript(CONTEXT_PATH . 'script/views/home/index/charts-controller.js');
    }

    public function BuildView() 
    {        
        $this->BuildHeader();
        
        include dirname(__FILE__) . '/Index/ChartDisplay.php';
        
        $this->BuildFooter();
    }    
}

?>
