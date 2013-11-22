<?php
namespace Library\Controller;

abstract class Controller 
{
    public function ProcessRequest(\Library\Routing\RequestContext $context)
    {
        $action = $context->GetAction();
        $actionResult = $this->$action($context->GetParameters());
        
        $actionResult->DoAction();
    }
}
?>
