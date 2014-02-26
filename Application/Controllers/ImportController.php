<?php

namespace Application\Controllers;

class ImportController extends \Library\Controller\Controller
{

    private $_importService;
    private $_crimeService;

    public function __construct(\Application\Services\ICrimeFileParsingService $importSerivce, \Application\Services\ICrimeService $crimeService)
    {
        $this->_importService = $importSerivce;
        $this->_crimeService = $crimeService;
    }

    public function Index()
    {
        return $this->ViewResult(new \Application\Views\Import\Index());
    }

    public function File()
    {
        $inputContentsHandle = fopen($_FILES['inputCsvFile']['tmp_name'], 'rt');
        
        $inputContents = array();
        
        while (($line = fgets($inputContentsHandle)) !== false) 
        {
            array_push($inputContents, $line);
        }
        
        $serializableStats = $this->CreateStatistics($inputContents);

        return $this->ViewResult(new \Application\Views\Import\ImportedData($serializableStats));
    }

    public function Text($inputContents)
    {   
        $inputContents = preg_split('/\r\n|[\r\n]/', $inputContents);
        
        $serializableStats = $this->CreateStatistics($inputContents);

        return $this->ViewResult(new \Application\Views\Import\ImportedData($serializableStats));
    }

    public function ErrorUploading()
    {
        return $this->ViewResult(new \Application\Views\Import\ErrorUploading());
    }

    public function Save()
    {
        return $this->RedirectToAction('');
    }

    private function CreateStatistics($inputContents)
    {
        $this->_crimeService->ClearCrimes();
        
        $stats = $this->_importService->ParseFile($inputContents);
        
        $this->_crimeService->SaveStatistics($stats);
        
        $serializableStats = new \Application\Persistence\XmlSerialisation\CrimesStatitics($stats);

        $xml = \Library\Persistence\XMLSerialiser::Serialise($serializableStats);
        
        return $xml;
    }

}
?>