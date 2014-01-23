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
        $this->AddScript(CONTEXT_PATH . 'script/views/client/index/put.controller.js');
        $this->AddScript(CONTEXT_PATH . 'script/views/client/index/post.controller.js');
        $this->AddScript(CONTEXT_PATH . 'script/views/client/index/delete.controller.js');
    }

    public function BuildView()
    {
        $this->BuildHeader();
        
        echo <<<HTML
        <div class="panel-group" id="accordion">
HTML;

        $this->PartialView('Application/Views/Client/Index/PutForm.php');
        
        $this->PartialView('Application/Views/Client/Index/PostForm.php');
        
        $this->PartialView('Application/Views/Client/Index/DeleteForm.php');
        
                echo <<<HTML
        </div>
HTML;
        
        $this->BuildFooter();
    }
}
?>