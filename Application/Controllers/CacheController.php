<?php
namespace Application\Controllers;

class CacheController extends \Library\Controller\Controller
{
    private $_cache;
    
    public function __construct(\Library\Caching\IRequestCache $cache)
    {
        $this->_cache = $cache;
    }
    
    public function ReturnCachedRequest($path)
    {        
        return new \Library\Controller\CacheResult($this->_cache->RetrieveCachedRequest($path));
    }
}
?>