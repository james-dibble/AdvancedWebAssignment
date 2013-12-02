<?php
namespace Library\Persistence;

class XMLSerialiser
{
    public static function Serialise($object)
    {
        $rootElement = new \DOMDocument();
        $rootElement->formatOutput = true;
        
        $reflectedObject = new \ReflectionObject($object);
        
        $serailisedObjectNode = XMLSerialiser::SerialiseChild($object, $reflectedObject->getShortName(), $rootElement);
        
        $rootElement->appendChild($serailisedObjectNode);
        
        return $rootElement;
    }
    
    public static function SerialiseChild($childObject, $childName, $domDocument)
    {
        $childElement = $domDocument->createElement(strtolower($childName));
        
        $reflectedObject = new \ReflectionObject($childObject);
        
        foreach($reflectedObject->getProperties() as $property)
        {
            if(is_scalar($property->getValue($childObject)))
            {
                $childElement->setAttribute($property->getName(), $property->getValue($childObject));
                continue;
            }
            
            if(is_array($property->getValue($childObject)))
            {
                $arrayElement = $domDocument->createElement($property->getName());
                
                foreach($property->getValue($childObject) as $arrayConent)
                {
                    $reflectedArrayObject = new \ReflectionObject($arrayConent);
                    
                    $arrayElement->appendChild(XMLSerialiser::SerialiseChild($arrayConent, $reflectedArrayObject->getShortName(), $domDocument));
                }
                
                $childElement->appendChild($arrayElement);
                
                continue;
            }
            
            $serialisedProperty = XMLSerialiser::SerialiseChild($property->getValue($childObject), $property->getName(), $domDocument);
            
            $childElement->appendChild($serialisedProperty);
        }
        
        return $childElement;
    }
}
?>
