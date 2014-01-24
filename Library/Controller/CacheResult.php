<?php
namespace Library\Controller;

class CacheResult implements \Library\Controller\IActionResult
{
    private $_cache;
    
    public function __construct(\Library\Caching\CachedRequest $cache)
    {
        $this->_cache = $cache;
    }
    
    public function DoAction()
    {
        if($this->_cache->type == 'json')
        {
            header('Content-type: application/json');
        }
        
        if($this->_cache->type == 'xml')
        {
            header('Content-type: application/xml');
        }
        
        echo $this->_cache->contents;
    }    
}
?>