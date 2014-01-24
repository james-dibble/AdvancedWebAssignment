<?php

namespace Library\Caching;

class RequestCache implements \Library\Caching\IRequestCache
{

    private $_basePath = "../cache/";

    public function CacheResponse($requestPath, $bufferContents, \Library\Controller\IActionResult $result)
    {
        // Redirects shouldn't be cached just incase the redirected action changes.
        if (get_class($result) == 'Library\Controller\RedirectToAction')
        {
            return;
        }

        $requestCachePath = $this->_basePath . $this->EscapeRequestPath($requestPath);

        if (get_class($result) == 'Library\Controller\ViewResult')
        {
            $requestCachePath .= '.html';
        }

        if (get_class($result) == 'Library\Controller\JsonResult')
        {
            $requestCachePath .= '.json';
        }

        if (get_class($result) == 'Library\Controller\XmlResult')
        {
            $requestCachePath .= '.xml';
        }

        $cacheHandel = fopen($requestCachePath, 'x');
        fwrite($cacheHandel, $bufferContents);
        fclose($cacheHandel);
    }

    public function EmptyCache()
    {        
        $dataCacheFiles = glob($this->_basePath . '*.{xml,json}', GLOB_BRACE);
               
        foreach ($dataCacheFiles as $cache)
        {
            if (is_file($cache))
            {
                unlink($cache);
            }
        }
    }

    public function IsCached($requestPath)
    {
        $requestCachePath = $this->_basePath . $this->EscapeRequestPath($requestPath) . '.*';

        return count(glob($requestCachePath)) > 0;
    }

    public function RetrieveCachedRequest($requestPath)
    {
        $requestCachePath = $this->_basePath . $this->EscapeRequestPath($requestPath) . '.*';

        $path = glob($requestCachePath)[0];

        $contents = file_get_contents($path);

        $path_parts = pathinfo($path);

        return new CachedRequest($contents, $path_parts['extension']);
    }

    private function EscapeRequestPath($requestPath)
    {
        return str_replace('/', '#', $requestPath);
    }

    private function UnescapeRequestPath($requestPath)
    {
        return str_replace('#', '/', $requestPath);
    }
}
?>