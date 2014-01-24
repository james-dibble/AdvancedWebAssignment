<?php

namespace Library\Routing;

class Router
{

    private $_container;
    private $_cache;

    public function __construct(\Library\Composition\IContainer $container)
    {
        $this->_container = $container;
        $this->_cache = $this->_container->Resolve('Library\Caching\IRequestCache');
    }

    public function Dispatch($controllerName, $actionName)
    {
        try
        {
            // Use the output buffer so we can clear the output stream
            // if something goes wrong
            ob_start();

            if ($this->_cache->IsCached($_SERVER['REQUEST_URI']))
            {
                $controller = $this->CreateController('cache');
                
                $actionResult = $controller->ReturnCachedRequest($_SERVER['REQUEST_URI']);
        
                $actionResult->DoAction();
        
                return;
            }

            $controller = $this->CreateController($controllerName);

            $actionResult = $controller->ProcessRequest($actionName);

            $actionResult->DoAction();

            $this->_cache->CacheResponse($_SERVER['REQUEST_URI'], ob_get_contents(), $actionResult);
        }
        catch (\Exception $ex)
        {
            // Something went wrong so clear the buffer so only our error
            // output is sent.
            ob_end_clean();

            $controller = $this->CreateController('errors');

            $controller->ProcessRequest('index', $ex);
        }
    }

    private function CreateController($controllerName)
    {
        $fullyQualifiedControllerName = '\Application\\Controllers\\' . ucwords($controllerName) . 'Controller';

        if (!class_exists($fullyQualifiedControllerName))
        {
            throw new \Library\Models\Errors\NotFoundException('Controller not found');
        }

        $controllerConstructorArguments = $this->BuildDependencies($fullyQualifiedControllerName);

        $controllerClass = new \ReflectionClass($fullyQualifiedControllerName);

        $controller = $controllerClass->newInstanceArgs($controllerConstructorArguments);

        return $controller;
    }

    private function BuildDependencies($controllerName)
    {
        $constructorArguments = array();

        $controller = new \ReflectionClass($controllerName);

        if (!method_exists($controllerName, '__construct'))
        {
            return $constructorArguments;
        }

        $constructor = $controller->getConstructor();
        $args = $constructor->getParameters();

        foreach ($args as $arg)
        {
            $resolved = $this->_container->Resolve($arg->getClass()->name);
            array_push($constructorArguments, $resolved);
        }

        return $constructorArguments;
    }

}

?>
