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

            foreach ($this->GetActionParameters($action) as $parameter)
            {
                array_push($actionParameterValues, $this->GetActionParameters([$parameter]));
            }

            $actionResult = $this->$action($actionParameterValues);
        }
        else
        {
            $actionResult = $this->$action($arguments);
        }

        $actionResult->DoAction();
    }

    private function GetActionParameters($actionName)
    {
        $method = new \ReflectionMethod($this, $actionName);

        return $method->getParameters();
    }

    private function GetRequestMethodParams()
    {
        switch ($_SERVER['REQUEST_METHOD'])
        {
            case 'GET':
                return $_GET;
            case 'POST':
                return $_POST;
            case 'PUT':
            case 'DELETE':
                parse_str(file_get_contents('php://input'), array());
            default:
                throw new \ErrorException('Request method not supported');
        }
    }

}

?>
