<?php
namespace Library\Caching;

interface IRequestCache
{
    function EmptyCache();
    
    function IsCached($requestPath);
    
    function RetrieveCachedRequest($requestPath);
    
    function CacheResponse($requestPath, $bufferContents, \Library\Controller\IActionResult $result);
}
?>