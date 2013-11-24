<?php

namespace Library\Controller;

class JsonResult implements IActionResult
{

    private $_model;

    public function __construct($model)
    {
        $this->_model = $model;
    }

    public function DoAction()
    {
        header('Content-type: application/json');

        $response = new JsonResponse();
        $response-> response = $this->_model;

        $asJson = json_encode($response, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);

        echo $asJson;
    }

}

class JsonResponse
{
    public $response;
}

?>
