<?php
namespace Application\Views\Client;

class Index extends \Application\Views\Layout\ApplicationLayout
{
    public function __construct()
    {
        parent::__construct();
        $this->SetTitle('API Methods');
        $this->SetDescription('API Methods');
        
        $this->AddScript(CONTEXT_PATH . 'script/jquery.linq.min.js');
        $this->AddScript(CONTEXT_PATH . 'script/views/client/index/post.controller.js');
    }

    public function BuildView()
    {
        $this->BuildHeader();

        $this->PartialView('Application/Views/Client/Index/PutForm.php');
        
        $this->PartialView('Application/Views/Client/Index/PostForm.php');
        
        $this->PartialView('Application/Views/Client/Index/DeleteForm.php');
        
        $this->BuildFooter();
    }
}
?>