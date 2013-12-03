<?php

namespace Library\Persistence;

class MySqlPersistenceManager implements \Library\Persistence\IPersistenceManager
{
    private $_statementsToCommit;
    private $_host;
    private $_user;
    private $_password;
    private $_mappers;
    private $_connection;

    public function __construct($host, $user, $password, \Library\Persistence\IMapperDictionary $mappers)
    {
        $this->_host = $host;
        $this->_user = $user;
        $this->_password = $password;
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

            foreach ($this->_statementsToCommit as $statement)
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

        $query = $this->GetConnection()->query($mapper->GetFindQuery($search) . ';');
        $query->setFetchMode(\PDO::FETCH_OBJ);
                
        while ($row = $query->fetch())
        {
            return $mapper->MapObject($row);
        }

        return null;
    }

    public function GetCollection(IPersistenceSearcher $search)
    {
        $mapper = $this->_mappers->GetMapper($search->TypeToSearch());

        $query = $this->GetConnection()->query($mapper->GetFindQuery($search) . ';');
        $query->setFetchMode(\PDO::FETCH_OBJ);

        $mappedObjects = array();

        while($row = $query->fetch())
        {
            $mappedObject = $mapper->MapObject($row);

            array_push($mappedObjects, $mappedObject);
        }

        return $mappedObjects;
    }

    private function GetConnection()
    {
        if ($this->_connection == null)
        {
            $this->_connection = new \PDO("mysql:host=$this->_host;dbname=fet10009689", $this->_user, $this->_password);  
        }

        return $this->_connection;
    }
}
?>