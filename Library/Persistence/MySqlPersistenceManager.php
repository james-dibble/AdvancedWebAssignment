<?php

namespace Library\Persistence;

class MySqlPersistenceManager implements \Library\Persistence\IPersistenceManager
{
    private $_statementsToCommit;
    private $_connectionString;
    private $_mappers;
    private $_connection;

    public function __construct($connectionString, array $mappers)
    {
        $this->_connectionString = $connectionString;
        $this->_mappers = $mappers;
        $this->_statementsToCommit = array();
    }

    public function Add($objectToAdd)
    {
        
    }

    public function Change($objectToChange)
    {
        
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
        
    }

    public function GetCollection(IPersistenceSearcher $search)
    {
        
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