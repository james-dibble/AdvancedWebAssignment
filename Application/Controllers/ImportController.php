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
        return new \Library\Controller\ViewResult(new \Application\Views\Import\Index());
    }

    public function File()
    {
        $fileDestination = '/tmp/' . $_FILES['inputCsvFile']['name'];

        move_uploaded_file($_FILES['inputCsvFile']['tmp_name'], $fileDestination);

        if (file_exists($fileDestination))
        {
            die('The file was uploaded');
        }

        return new \Library\Controller\RedirectToAction('import');
    }

    public function Text($inputContents)
    {
        try
        {
            if (file_exists('/tmp/import.xml'))
            {
                unlink('/tmp/import.xml');
            }
            
            $this->_crimeService->ClearCrimes();
            
            $inputContents = preg_split('/\r\n|[\r\n]/', $inputContents);

            $stats = $this->_importService->ParseFile($inputContents);
            
            $this->_crimeService->SaveStatistics($stats);

            $statsAsXml = \Library\Persistence\XMLSerialiser::Serialise($stats);

            $statsAsXml->save('/tmp/import.xml');

            die();
            
            return new \Library\Controller\RedirectToAction('import/imported-data');
        }
        catch (\Exception $ex)
        {            
            die($ex->getmessage());
            return new \Library\Controller\RedirectToAction('import/error');
        }
    }

    public function ErrorUploading()
    {
        return new \Library\Controller\ViewResult(new \Application\Views\Import\ErrorUploading());
    }

    public function ImportedData()
    {
        $statsAsXml = new \DOMDocument();
        $statsAsXml->load('/tmp/import.xml');
        
        return new \Library\Controller\ViewResult(new \Application\Views\Import\ImportedData($statsAsXml));
    }

    public function Save()
    {
        return new \Library\Controller\RedirectToAction('');
    }
}
?>