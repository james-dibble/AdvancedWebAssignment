<?php
namespace Application\Persistence\XmlSerialisation;

class Area implements \Library\Persistence\IXmlSchemaMember
{
    public $name;
    public $statistic;
    
    public function __construct(\Application\Models\Domain\Area $area)
    {
        $this->statistic = array();
        
        $this->name = $area->name;
        
        foreach($area->crimeStatistics as $crimeStatistic)
        {
            array_push($this->statistic, new CrimeStatistic($crimeStatistic));
        }
    }

    public function SchemaPath()
    {
        return SCHEMA_PATH;
    }

    public function SchemaProperty()
    {
        return 'cs:area';
    }
}
?>