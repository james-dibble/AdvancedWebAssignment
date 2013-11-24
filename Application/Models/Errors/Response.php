<?php
namespace Application\Models\Errors;

class Response
{   
    public $timestamp;
    public $error;
    
    public function __construct()
    {
        $this->timestamp = time();
    }
}
?>
