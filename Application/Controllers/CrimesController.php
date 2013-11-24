<?php
namespace Application\Controllers;

class CrimesController extends \Library\Controller\Controller
{
    public function Get($year, $format)
    {
        $response = new \Application\Models\Domain\Response();
        
        $crimes = new \Application\Models\Domain\CrimeStatistics();
        $crimes->year = $year;
        
        $response->crimes = $crimes;
        
        if($format === 'xml')
        {
            return new \Library\Controller\XMLResult($response);
        }
        
        if($format === 'json')
        {
            return new \Library\Controller\JsonResult($response);
        }
    }
}
?>
