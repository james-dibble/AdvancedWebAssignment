<?php

namespace Library\Persistence;
/**
 * An object to DOMObject converter class.
 */
class XMLSerialiser
{
    public static function Serialise($object, $arraysAsElements = false)
    {
        // We should have captured any errors from previous seralisations by
        // now so setup this rediculous way of capturing errors from XML
        // serialisation an validation.
        libxml_clear_errors();
        libxml_use_internal_errors(true);
        
        $rootElement = new \DOMDocument("1.0", "utf-8");
        $rootElement->formatOutput = true;

        $reflectedObject = new \ReflectionObject($object);

        $serailisedObjectNode = XMLSerialiser::SerialiseChild($object, $reflectedObject->getShortName(), $rootElement, $arraysAsElements);
            
        if($object instanceof \Library\Persistence\IXmlSchemaMember)
        {
            $serailisedObjectNode->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
            $serailisedObjectNode->setAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'schemaLocation', $object->SchemaPath() . ' ./CrimeRecord.xsd');
        }

        $rootElement->appendChild($serailisedObjectNode);
        
        return $rootElement;
    }

    public static function SerialiseChild($childObject, $childName, $domDocument, $arraysAsElements = false)
    {
        $childElement = null;
        
        // This object is part of a schema so pop it into the documents namespace.
        if($childObject instanceof \Library\Persistence\IXmlSchemaMember)
        {
            $childElement = $domDocument->createElementNS($childObject->SchemaPath(), $childObject->SchemaProperty());
        }
        else
        {
            $childElement = $domDocument->createElement(strtolower($childName));
        }
        
        $reflectedObject = new \ReflectionObject($childObject);

        foreach ($reflectedObject->getProperties() as $property)
        {
            if ($property->getValue($childObject) == null)
            {
                $childElement->setAttribute($property->getName(), 'null');
                continue;
            }

            if (is_scalar($property->getValue($childObject)))
            {
                $childElement->setAttribute($property->getName(), $property->getValue($childObject));
                continue;
            }

            if (is_array($property->getValue($childObject)))
            {
                $arrayElement = $childElement;

                if ($arraysAsElements)
                {
                    $arrayElement = $domDocument->createElement($property->getName());
                }

                foreach ($property->getValue($childObject) as $arrayContent)
                {
                    // If the serialiser was set to use the type of object as the elements name otherwise use the name of
                    // the property the array was on.
                    if ($arraysAsElements)
                    {
                        $reflectedArrayObject = new \ReflectionObject($arrayContent);

                        $arrayElement->appendChild(XMLSerialiser::SerialiseChild($arrayContent, $reflectedArrayObject->getShortName(), $domDocument, $arraysAsElements));
                    }
                    else
                    {
                        $arrayElement->appendChild(XMLSerialiser::SerialiseChild($arrayContent, $property->getName(), $domDocument, $arraysAsElements));
                    }
                }

                if ($arraysAsElements)
                {
                    $childElement->appendChild($arrayElement);
                }

                continue;
            }

            // We have another object so recursivly call the function to extract the object.
            $serialisedProperty = XMLSerialiser::SerialiseChild($property->getValue($childObject), $property->getName(), $domDocument);

            $childElement->appendChild($serialisedProperty);
        }

        return $childElement;
    }

}
?>