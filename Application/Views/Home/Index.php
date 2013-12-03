<?php
namespace Application\Views\Home;

class Index extends \Application\Views\Layout\ApplicationLayout implements \Library\Views\IView 
{
    public function __construct()
    {
        parent::__construct();
        $this->SetTitle('Home');
        $this->SetDescription('Home');
        
        $path = dirname(__FILE__) . '\\..\\..\\..\\Public\\script\\jchartfx\\';
                
        $files = glob($path . '*.{js}', GLOB_BRACE);
        foreach ($files as $file)
        {
            $this->AddScript(CONTEXT_PATH . 'script/jchartfx/' . basename($file));
        }
        
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
