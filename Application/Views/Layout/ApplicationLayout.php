<?php
namespace Application\Views\Layout;

abstract class ApplicationLayout extends \Application\Views\Layout\BasicBootstrapLayout
{
    public function __construct()
    {
        parent::__construct();
        
        $this->AddScript('//ajax.googleapis.com/ajax/libs/angularjs/1.2.3/angular.min.js');
        $this->AddScript(CONTEXT_PATH . 'script/angular.localstorage.js');
        $this->AddScript(CONTEXT_PATH . 'script/global.js');
    }
    
    public function BuildHeader()
    {
        parent::BuildHeader();
        
        include 'ApplicationHeader.php';
    }
}
?>
