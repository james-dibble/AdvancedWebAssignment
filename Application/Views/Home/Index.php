<?php
namespace Application\Views\Home;

class Index extends \Application\Views\Layout\BasicBootstrapLayout implements \Library\Views\IView 
{
    public function __construct()
    {
        parent::__construct();
        $this->SetTitle('Home');
        $this->SetDescription('Home');
    }

    public function BuildView() 
    {        
        $this->BuildHeader();
        echo <<<HTML
        <h1>Home/Index</h1>
HTML;
        $this->BuildFooter();
    }    
}

?>
