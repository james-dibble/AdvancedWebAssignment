<?php
namespace Application\Models\Domain;

class Response
{   
    public $timestamp;
    public $crimes;
    
    public function __construct()
    {
        $this->timestamp = time();
    }
}
?>
