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

        $query = $this->GetConnection()->prepare('CALL ' . $mapper->GetFindQuery($search));

        $query->execute();

        $query->store_result();

        $result = $query->get_result();
        while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            $mappedObject = $mapper->MapObject($row);
        }

        $query->free_result();

        $query->close();

        return $mappedObject;
    }

    public function GetCollection(IPersistenceSearcher $search)
    {
        $mapper = $this->_mappers->GetMapper($search->TypeToSearch());

        $query = $this->GetConnection()->prepare('CALL ' . $mapper->GetFindQuery($search));

        if (!$query->execute())
        {
            throw new \Exception($query->error, $query->errno);
        }

        $query->store_result();

        $mappedObjects = array();

        $results = $this->BindResults($query);
        foreach ($results as $row)
        {
            $mappedObject = $mapper->MapObject($row);

            array_push($mappedObjects, $mappedObject);
        }

        $query->free_result();

        $query->close();

        return $mappedObjects;
    }

    private function GetConnection()
    {
        if ($this->_connection == null)
        {
            $this->_connection = new \mysqli($this->_host, $this->_user, $this->_password, 'fet10009689');
        }

        return $this->_connection;
    }
}
?>