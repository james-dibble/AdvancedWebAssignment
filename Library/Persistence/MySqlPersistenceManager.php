<?php

namespace Library\Persistence;

class MySqlPersistenceManager implements \Library\Persistence\IPersistenceManager
{
    private $_statementsToCommit;
    private $_host;
    private $_user;
    private $_password;
    private $_database;
    private $_mappers;
    private $_connection;

    public function __construct($host, $user, $password, $database, \Library\Persistence\IMapperDictionary $mappers)
    {
        $this->_connection = null;
        $this->_host = $host;
        $this->_user = $user;
        $this->_password = $password;
        $this->_database = $database;
        $this->_mappers = $mappers;
        $this->_statementsToCommit = array();
    }

    public function Add($objectToAdd, array $referenceObjects)
    {
        if($objectToAdd == null)
        {
            throw new \Exception('Object being added is null');
        }
        
        $mapper = $this->_mappers->GetMapper(new \ReflectionClass($objectToAdd));

        foreach($mapper->GetAddQueries($objectToAdd, $referenceObjects) as $query)
        {
            array_push($this->_statementsToCommit, $query);
        }
    }

    public function Change($objectToChange, array $referenceObjects)
    {
        if($objectToChange == null)
        {
            throw new \Exception('Object being changed is null');
        }
        
        $mapper = $this->_mappers->GetMapper(new \ReflectionClass($objectToChange));

        foreach($mapper->GetChangeQueries($objectToChange, $referenceObjects) as $query)
        {
            array_push($this->_statementsToCommit, $query);
        }
    }

    public function Delete($objectToDelete = null, IPersistenceSearcher $search = null) 
    {
        $mapper = null;
        
        if($objectToDelete != null)
        {
            $mapper = $this->_mappers->GetMapper(new \ReflectionClass($objectToDelete));
        }
        
        if($search != null)
        {
            $mapper = $this->_mappers->GetMapper($search->TypeToSearch());
        }
        
        foreach($mapper->GetDeleteQueries($objectToDelete, $search) as $query)
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
                #echo $statement . PHP_EOL;
                
                $this->GetConnection()->exec($statement);
            }

            $this->GetConnection()->commit();
            
            $this->_statementsToCommit = array();
        }
        catch (\Exception $e)
        {
            $this->GetConnection()->rollBack();
            throw $e;
        }
    }

    public function Get(IPersistenceSearcher $search)
    {        
        $mapper = $this->_mappers->GetMapper($search->TypeToSearch());

        $query = $this->GetConnection()->query($mapper->GetFindQuery($search) . ';');
        
        //echo $mapper->GetFindQuery($search) . ';' . PHP_EOL;
                
        $query->setFetchMode(\PDO::FETCH_OBJ);
                
        while ($row = $query->fetch())
        {
            return $mapper->MapObject($row, $search);
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
            $mappedObject = $mapper->MapObject($row, $search);

            array_push($mappedObjects, $mappedObject);
        }

        return $mappedObjects;
    }

    private function GetConnection()
    {
        if ($this->_connection == null)
        {
            $this->_connection = new \PDO("mysql:host=$this->_host;dbname=$this->_database", $this->_user, $this->_password);
        }
        
        return $this->_connection;
    }
}
?>