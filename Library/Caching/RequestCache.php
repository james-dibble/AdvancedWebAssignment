<?php

namespace Library\Caching;

class RequestCache implements \Library\Caching\IRequestCache
{

    private $_basePath = "../cache/";

    /**
     * Save a response to the cache.
     */
    public function CacheResponse($requestPath, $bufferContents, \Library\Controller\IActionResult $result)
    {
        // Redirects shouldn't be cached just incase the redirected action changes.
        if ($result instanceof \Library\Controller\RedirectToAction)
        {
            return;
        }

        $requestCachePath = $this->_basePath . $this->EscapeRequestPath($requestPath);

        if ($result instanceof \Library\Controller\ViewResult)
        {
            $requestCachePath .= '.html';
        }

        if ($result instanceof \Library\Controller\JsonResult)
        {
            $requestCachePath .= '.json';
        }

        if ($result instanceof \Library\Controller\XmlResult)
        {
            $requestCachePath .= '.xml';
        }

        if (!file_exists($requestCachePath) && ($cacheHandle = fopen($requestCachePath, 'x+')) !== false)
        {
            fwrite($cacheHandle, $bufferContents);
            fclose($cacheHandle);
        }        
    }

    /**
     * Delete all data responses.
     */
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