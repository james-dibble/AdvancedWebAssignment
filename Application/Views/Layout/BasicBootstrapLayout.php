<?php
namespace Application\Views\Layout;

abstract class BasicBootstrapLayout extends \Application\Views\Layout\BasicHtmlLayout
{
    public function __construct()
    {
        parent::__construct();
        $this->AddStyleSheet('//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css');
    }
    
    public function BuildHeader()
    {
        parent::BuildHeader();
        
        echo <<<HTML
        <div class="container">
HTML;
    }
    
    public function BuildFooter()
    {
                echo <<<HTML
        </div>
HTML;
                
        parent::BuildFooter();
    }
}
?>