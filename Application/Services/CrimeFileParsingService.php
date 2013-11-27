<?php
namespace Application\Services;

class CrimeFileParser implements ICrimeFileParsingService
{
    private $_fileContents;
    private $_rowPointer;
    private $_countries = array('England', 'Wales');
    
    public function __construct($fileContents)
    {
        $this->_rowPointer = 0;
        $this->_fileContents - $fileContents;
    }
    
    public function ParseFile()
    {
        $countries = array();
        
        while($this->_rowPointer > count($this->_fileContents))
        {
            $country = $this->ParseCountry();
            
            array_push($countries, $country);
            
            $this->_rowPointer ++;
        }
        
        return $countries;
    }  
    
    private function ParseCountry()
    {
        $country = null;
        
        while($this->_rowPointer > count($this->_fileContents))
        {
            $lineContents = str_getcsv($this->_fileContents[$this->_rowPointer]);
            
            if(in_arrayi($lineContents[0], $this->_countries))
            {
                return $country;
            }
            
            $region = $this->ParseRegion();
            
            $this->_rowPointer ++;
        }
    }
    
    private function ParseRegion()
    {
        $region = null;
        
        while($this->_rowPointer > count($this->_fileContents))
        {
            $lineContents = str_getcsv($this->_fileContents[$this->_rowPointer]);
            
            if(preg_match('^[A-Za-z ]+ Region$', $lineContents[0]))
            {
                return $region;
            }
            
            $area = $this->ParseArea();
                                    
            $this->_rowPointer ++;
        }
    }
    
    private function ParseArea()
    {
        $area = null;
        
        $lineContents = str_getcsv($this->_fileContents[$this->_rowPointer]);
        
        return $area;
    }
    
    // From: http://uk.php.net/manual/en/function.in-array.php#89256
    private static function in_arrayi($needle, $haystack) 
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }
}

?>
