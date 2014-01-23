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
        $fileDestination = '/tmp/' . $_FILES['inputCsvFile']['name'];

        move_uploaded_file($_FILES['inputCsvFile']['tmp_name'], $fileDestination);

        if (file_exists($fileDestination))
        {
            die('The file was uploaded');
        }

        return $this->RedirectToAction('import');
    }

    public function Text($inputContents)
    {
        try
        {
            $this->_crimeService->ClearCrimes();
            
            $inputContents = preg_split('/\r\n|[\r\n]/', $inputContents);

            $stats = $this->_importService->ParseFile($inputContents);
            
            $this->_crimeService->SaveStatistics($stats);
            
            $serializableStats = new \Application\Persistence\XmlSerialisation\CrimesStatitics($stats);

            return $this->XmlResult($serializableStats);
        }
        catch (\Exception $ex)
        {            
            die($ex->getmessage());
            return $this->RedirectToAction('import/error');
        }
    }

    public function ErrorUploading()
    {
        return $this->ViewResult(new \Application\Views\Import\ErrorUploading());
    }

    public function ImportedData()
    {
        $statsAsXml = new \DOMDocument();
        $statsAsXml->load('/tmp/import.xml');
        
        return $this->ViewResult(new \Application\Views\Import\ImportedData($statsAsXml));
    }

    public function Save()
    {
        return $this->RedirectToAction('');
    }
}
?>