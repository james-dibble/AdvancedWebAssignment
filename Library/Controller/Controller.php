<?php

namespace Library\Controller;

abstract class Controller
{
    public function ProcessRequest($action, $arguments = null)
    {
        $actionResult = null;

        if ($arguments == null)
        {
            $actionParameterValues = array();
            $requestMethodParams = $this->GetRequestMethodParams();
            $actionParameters = $this->GetActionParameters($action);

            foreach ($actionParameters as $parameter)
            {
                if(!isset($requestMethodParams[$parameter->name]))
                {
                    throw new \Library\Models\Errors\UriNotRecognizedException('Parameters do not match action method');
                }
                
                array_push($actionParameterValues, $requestMethodParams[$parameter->name]);
            }

            $actionResult = call_user_func_array(array($this, $action), $actionParameterValues);
        }
        else
        {
            $actionResult = $this->$action($arguments);
        }

        $actionResult->DoAction();
    }
    
    protected function ViewResult(\Library\Views\IView $view)
    {
        return new \Library\Controller\ViewResult($view);
    }
    
    protected function RedirectToAction($action)
    {
        return new \Library\Controller\RedirectToAction($action);
    }
    
    protected function JsonResult($object)
    {
        return new \Library\Controller\JsonResult($object);
    }
    
    protected function XmlResult($object)
    {
        return new \Library\Controller\XMLResult($object);
    }

    private function GetActionParameters($actionName)
    {
        if(!method_exists($this, $actionName))
        {
            $controllerName = $this->GetControllerName();
            throw new \Library\Models\Errors\NotFoundException("Action [$actionName] does not exists on controller [$controllerName].");
        }
        
        $method = new \ReflectionMethod($this, $actionName);

        return $method->getParameters();
    }

    private function GetRequestMethodParams()
    {
        $params = null;
        
        switch ($_SERVER['REQUEST_METHOD'])
        {
            case 'GET':
                $params = $_GET;
                break;
            case 'POST':
                $params = $_POST;
                break;
            case 'PUT':
            case 'DELETE':
                $params = parse_str(file_get_contents('php://input'), array());
                break;
            default:
                throw new \ErrorException('Request method not supported');
        }
        
        return $params;
    }

    private function GetControllerName()
    {
        $controller = new \ReflectionClass($this);
        
        return $controller->getShortName();
    }
}

?>
