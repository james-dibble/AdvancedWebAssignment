<?php
namespace Application\Persistence\XmlSerialisation;

class Country implements \Library\Persistence\IXmlSchemaMember
{
    public $name;
    public $region;
    
    public function __construct(\Application\Models\Domain\Country $country)
    {
        $this->region = array();
        
        $this->name = $country->name;
        
        foreach($country->regions as $region)
        {
            array_push($this->region, new \Application\Persistence\XmlSerialisation\Region($region));
        }
    }

    public function SchemaPath()
    {
        return SCHEMA_PATH;
    }

    public function SchemaProperty()
    {
        return 'cs:country';
    }
}
?>