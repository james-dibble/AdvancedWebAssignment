<?php
namespace Application\Views\Layout;

abstract class ApplicationLayout extends \Application\Views\Layout\BasicBootstrapLayout
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function BuildHeader()
    {
        parent::BuildHeader();
        
        include 'ApplicationHeader.php';
    }
}
?>
