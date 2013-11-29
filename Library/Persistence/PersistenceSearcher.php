<?php
namespace Library\Persistence;

class PersistenceSearcher implements \Library\Persistence\IPersistenceSearcher
{
    private $_searchCriteria;
    private $_searchType;
    
    public function __construct(\ReflectionClass $searchType, array $searchCriteria)
    {
        $this->_searchCriteria = $searchCriteria;
        $this->_searchType = $searchType;
    }

    public function GetKey($key)
    {
        return $this->_searchCriteria[$key];
    }

    public function HasKey($key)
    {
        return array_key_exists($key, $this->_searchCriteria);
    }

    public function TypeToSearch()
    {
        return $this->_searchType;
    }    
}
?>