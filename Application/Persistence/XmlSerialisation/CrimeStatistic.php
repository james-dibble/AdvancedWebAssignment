<?php
namespace Application\Persistence\XmlSerialisation;

class CrimeStatistic  implements \Library\Persistence\IXmlSchemaMember
{
    public $type;
    public $total;
    
    public function __construct(\Application\Models\Domain\CrimeStatistic $crimeStatistic)
    {
        $this->type = $crimeStatistic->type->name;
        $this->total = $crimeStatistic->value;
    }
    
    public function SchemaPath()
    {
        return SCHEMA_PATH;
    }

    public function SchemaProperty()
    {
        return 'cs:statistic';
    }
}
?>