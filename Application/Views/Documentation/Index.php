<?php
namespace Application\Views\Documentation;

class Index extends \Application\Views\Layout\ApplicationLayout implements \Library\Views\IView
{
    public function __construct()
    {
        parent::__construct();
        $this->SetTitle('Advanced Topics in Web Development - James Dibble 10009689');
        $this->SetDescription('Advanced Topics in Web Development - James Dibble 10009689');
        
        $this->AddScript('https://raw2.github.com/darcyclarke/Repo.js/master/repo.min.js');
        $this->AddScript(CONTEXT_PATH . 'script/views/documentation/index/doc.min.js');
    }
    
    public function BuildView()
    {
        $this->BuildHeader();

        include dirname(__FILE__) . '/Index/Report.php';

        $this->BuildFooter();
    }    
}
?>