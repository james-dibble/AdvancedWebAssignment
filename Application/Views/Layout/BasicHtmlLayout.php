<?php  
namespace Application\Views\Layout;

abstract class BasicHtmlLayout extends \Library\Views\View
{
    private $_styleSheets;
    private $_scripts;
    private $_title;
    private $_description;
    
    public function __construct()
    {
        $this->_styleSheets = array();
        $this->_scripts = array();
        $this->AddScript('//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
    }

    protected function BuildHeader()
    {
        echo <<<HTML
<!DOCTYPE html>
<html lang="en" data-ng-app="atwd">
<head>
        <title>$this->_title</title>
        <!-- LE META -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="Description" content="$this->_description" />
HTML;
        include 'MetaTags.php';
        echo <<<HTML
        <!-- LE STYLE -->
        {$this->BuildStyleSheets()}
</head>
<body data-spy="scroll" data-target="#scrollTarget" data-offeset="50">
HTML;
    }

    protected function BuildFooter()
    {
        echo <<<HTML
</body>
 <!-- LE JAVASCRIPT -->
{$this->BuildScripts()}
</html>
HTML;
    }

    protected function SetTitle($title)
    {
        $this->_title = $title;
    }
    
    protected function SetDescription($description)
    {
        $this->_description = $description;
    }

    protected function AddStyleSheet($path)
    {
        array_push($this->_styleSheets, $path);
    }
    
    protected function AddScript($path)
    {
        array_push($this->_scripts, $path);
    }
    
    private function BuildStyleSheets()
    {
        $html = '';
        
        foreach($this->_styleSheets as $styleSheet)
        {
            $html .= <<<HTML
            <link rel="stylesheet" href="$styleSheet" />
HTML;
        }
        
        return $html;
    }
    
    private function BuildScripts()
    {
        $html = '';
        
        foreach($this->_scripts as $script)
        {
            $html .= <<<HTML
            <script type="text/javascript" src="$script"></script>
HTML;
        }
        
        return $html;
    }
}
?>
