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

        foreach($mapper->GetAddQueries($objectToAdd) as $query)
        {
            array_push($this->_statementsToCommit, $query);
        }
    }

    public function Change($objectToChange)
    {
        $mapper = $this->_mappers->GetMapper(new \ReflectionClass($objectToChange));

        foreach($mapper->GetChangeQueries($objectToChange) as $query)
        {
            array_push($this->_statementsToCommit, $query);
        }
    }

    public function Commit()
    {
        try
        {
            $this->GetConnection()->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $this->GetConnection()->beginTransaction();

            foreach ($this->_statementsToCommit as $statement)
            {
                echo $statement . '<br /><br />';
                
                $this->GetConnection()->exec($statement);
            }

            $this->GetConnection()->commit();
        }
        catch (Exception $e)
        {
            $this->GetConnection()->rollBack();
            throw $e;
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