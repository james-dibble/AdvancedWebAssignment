<?php

namespace Application\Views\Home;

class Index extends \Application\Views\Layout\ApplicationLayout implements \Library\Views\IView
{

    public function __construct()
    {
        parent::__construct();
        $this->SetTitle('Home');
        $this->SetDescription('Home');

        $this->AddScript(CONTEXT_PATH . 'script/jquery.linq.min.js');
        $this->AddScript(CONTEXT_PATH . 'script/highcharts/highcharts.js');
        $this->AddScript(CONTEXT_PATH . 'script/views/home/index/index.region.controller.js');
        $this->AddScript(CONTEXT_PATH . 'script/views/home/index/index.area.controller.js');
    }

    public function BuildView()
    {
        $this->BuildHeader();

        $this->PartialView('Application/Views/Home/Index/ChartDisplay.php');

        $this->BuildFooter();
    }

}

?>
