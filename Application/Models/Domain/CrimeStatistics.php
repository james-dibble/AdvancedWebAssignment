<?php
namespace Application\Models\Domain;

class CrimeStatistics
{
    public $homocide = 0;
    public $violenceWithInjury = 0;
    public $violenceWithoutInjury = 0;
    public $sexualOffenses = 0;
    public $robbery = 0;
    public $theftOffenses = 0;
    public $domesticBurglary = 0;
    public $nonDomesticBurglary = 0;
    public $vehicleOffenses = 0;
    public $theftFromPerson = 0;
    public $bicycleTheft = 0;
    public $shoplifting = 0;
    public $miscTheft = 0;
    public $criminalDamageAndArson = 0;
    public $drugOffenses = 0;
    public $possesionOfWeapons = 0;
    public $publicOrderOffenses = 0;
    public $miscCrimes = 0;
    public $fraud = 0;

    public function GetTotal() 
    {
        $total = 0;

        $total += 
                $this->homocide +
                $this->violenceWithInjury +
                $this->violenceWithoutInjury +
                $this->sexualOffenses +
                $this->robbery +
                $this->theftOffenses +
                $this->domesticBurglary +
                $this->nonDomesticBurglary +
                $this->vehicleOffenses +
                $this->theftFromPerson +
                $this->bicycleTheft +
                $this->shoplifting +
                $this->miscTheft +
                $this->criminalDamageAndArson +
                $this->drugOffenses +
                $this->possesionOfWeapons +
                $this->publicOrderOffenses +
                $this->miscCrimes +
                $this->fraud;

        return $total;
    }
}

?>
