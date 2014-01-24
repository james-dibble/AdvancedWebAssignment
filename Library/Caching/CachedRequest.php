<?php
namespace Library\Caching;

class CachedRequest
{
    public $contents;
    public $type;
    
    public function __construct($contents, $type)
    {
        $this->contents = $contents;
        $this->type = $type;
    }
}
?>