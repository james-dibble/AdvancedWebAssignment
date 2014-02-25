<?php
namespace Application\Persistence\XmlSerialisation;

class Region  implements \Library\Persistence\IXmlSchemaMember
{
    public $name;
    public $area;
    
    public function __construct(\Application\Models\Domain\Region $region)
    {
        $this->area = array();
            
        $this->name = $region->name;
        
        foreach($region->areas as $area)
        {
            array_push($this->area, new \Application\Persistence\XmlSerialisation\Area($area));
        }
    }
    
    public function SchemaPath()
    {
        return SCHEMA_PATH;
    }

    public function SchemaProperty()
    {
        return 'cs:region';
    }
}
?>