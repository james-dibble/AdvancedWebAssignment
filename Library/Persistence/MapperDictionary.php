<?php
namespace Library\Persistence;

class MapperDictionary implements \Library\Persistence\IMapperDictionary
{
    private $_mappers;
    
    public function __construct()
    {
        $this->_mappers = array();
    }

    public function Add(\Library\Persistence\IMapper $mapper)
    {
        array_push($this->_mappers, $mapper);
    }

    public function GetMapper(\ReflectionClass $class)
    {
        foreach($this->_mappers as $mapper)
        {
            if($class->getName() == $mapper->GetMappedClass()->getName())
            {
                return $mapper;
            }
        }
        
        return null;
    }    
}

?>
