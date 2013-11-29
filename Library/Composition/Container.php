<?php
namespace Library\Composition;

class Container implements IContainer
{
    private $_mappingDictionary;
    
    public function __construct() 
    {
        $this->_mappingDictionary = array();
    }


    public function Resolve($binding)
    {
        if(!array_key_exists($binding, $this->_mappingDictionary))
        {
            return null;
        }
        
        $boundObject = $this->_mappingDictionary[$binding][0];
        
        return $boundObject;
    }
    
    public function ResolveAll($binding)
    {
        if(!array_key_exists($binding, $this->_mappingDictionary))
        {
            return array();
        }
        
        $boundObjects = $this->_mappingDictionary[$binding];
        
        return $boundObjects;
    }
    
    public function Bind($binding, $object)
    {
        if(array_key_exists($binding, $this->_mappingDictionary))
        {
            array_push($this->_mappingDictionary[$binding], $object);
            return;
        }
        
        $this->_mappingDictionary[$binding] = array($object);
    }
}
?>
