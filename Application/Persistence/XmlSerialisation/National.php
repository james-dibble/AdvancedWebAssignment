<?php
namespace Application\Persistence\XmlSerialisation;

class National  implements \Library\Persistence\IXmlSchemaMember
{
    public $name;
    public $statistic;
    
    public function __construct(\Application\Models\Domain\National $national)
    {
        $this->statistic = array();
        
        $this->name = $national->name;
        
        foreach($national->crimeStatistics as $crimeStatistic)
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
        return 'cs:national';
    }
}
?>