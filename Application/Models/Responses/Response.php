<?php
namespace Application\Models\Responses;

class Response
{   
    public $timestamp;
    public $crimes;
    
    public function __construct()
    {
        $this->timestamp = time();
        $this->crimes = array();
    }
}
?>
