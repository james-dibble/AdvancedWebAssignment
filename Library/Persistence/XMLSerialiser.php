<?php
namespace Library\Persistence;

class XMLSerialiser
{
    public static function Serialise($object, $arraysAsElements = false, $schema = false)
    {
        $rootElement = new \DOMDocument();
        $rootElement->formatOutput = true;
        
        if($schema)
        {
            $rootElement = $rootElement->createElementNS('http://www.cems.uwe.ac.uk/~j3-dibble/CrimeRecord.xsd', 'crimes'); 
        }
        
        $reflectedObject = new \ReflectionObject($object);
        
        $serailisedObjectNode = XMLSerialiser::SerialiseChild($object, $reflectedObject->getShortName(), $rootElement, $arraysAsElements);
        
        $rootElement->appendChild($serailisedObjectNode);
        
        return $rootElement;
    }
    
    public static function SerialiseChild($childObject, $childName, $domDocument, $arraysAsElements = false)
    {
        $childElement = $domDocument->createElement(strtolower($childName));
        
        $reflectedObject = new \ReflectionObject($childObject);
        
        foreach($reflectedObject->getProperties() as $property)
        {
            if($property->getValue($childObject) == null)
            {
                $childElement->setAttribute($property->getName(), 'null');
                continue;
            }
            
            if(is_scalar($property->getValue($childObject)))
            {
                $childElement->setAttribute($property->getName(), $property->getValue($childObject));
                continue;
            }
            
            if(is_array($property->getValue($childObject)))
            {
                $arrayElement = $childElement;
                
                if($arraysAsElements)
                {
                    $arrayElement = $domDocument->createElement($property->getName());
                }
                
                foreach($property->getValue($childObject) as $arrayContent)
                {   
                    if($arraysAsElements)
                    {
                        $reflectedArrayObject = new \ReflectionObject($arrayContent);
                    
                        $arrayElement->appendChild(XMLSerialiser::SerialiseChild($arrayContent, $reflectedArrayObject->getShortName(), $domDocument, $arraysAsElements));
                    }
                    else
                    {
                        $arrayElement->appendChild(XMLSerialiser::SerialiseChild($arrayContent, $property->getName(), $domDocument, $arraysAsElements));
                    }
                }
                
                if($arraysAsElements)
                {
                    $childElement->appendChild($arrayElement);
                }
                
                continue;
            }
            
            $serialisedProperty = XMLSerialiser::SerialiseChild($property->getValue($childObject), $property->getName(), $domDocument);
            
            $childElement->appendChild($serialisedProperty);
        }
        
        return $childElement;
    }
}
?>
