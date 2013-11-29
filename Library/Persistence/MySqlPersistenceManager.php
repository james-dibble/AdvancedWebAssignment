<?php

namespace Library\Persistence;

class MySqlPersistenceManager implements \Library\Persistence\IPersistenceManager
{
    private $_statementsToCommit;
    private $_connectionString;
    private $_mappers;
    private $_connection;

    public function __construct($connectionString, \Library\Persistence\IMapperDictionary $mappers)
    {
        $this->_connectionString = $connectionString;
        $this->_mappers = $mappers;
        $this->_statementsToCommit = array();
    }

    public function Add($objectToAdd)
    {
        $mapper = $this->_mappers->GetMapper(new \ReflectionClass($objectToAdd));
        
        array_push($this->_statementsToCommit, $mapper->GetAddQueries($objectToAdd));
    }

    public function Change($objectToChange)
    {
        $mapper = $this->_mappers->GetMapper(new \ReflectionClass($objectToChange));
        
        array_push($this->_statementsToCommit, $mapper->GetChangeQueries($objectToChange));
    }

    public function Commit()
    {
        try
        {
            $this->GetConnection()->autocommit(FALSE);
            
            foreach($this->_statementsToCommit as $statement)
            {
                $this->GetConnection()->query($statement);
            }

            $this->GetConnection()->commit();
            $this->GetConnection()->autocommit(TRUE);
        }
        catch (Exception $e)
        {
            $this->GetConnection()->rollback();
            $this->GetConnection()->autocommit(TRUE);
        }
    }

    public function Get(IPersistenceSearcher $search)
    {
        $mapper = $this->_mappers->GetMapper($search->TypeToSearch());
    }

    public function GetCollection(IPersistenceSearcher $search)
    {
        $mapper = $this->_mappers->GetMapper($search->TypeToSearch());
    }

    private function GetConnection()
    {
        if ($this->_connection == null)
        {
            $this->_connection = mysqli_connect($this->_connectionString);
        }

        return $this->_connection;
    }
}
?>