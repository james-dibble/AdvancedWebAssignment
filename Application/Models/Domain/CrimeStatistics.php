<?php
namespace Application\Models\Domain;

class CrimeStatistics
{
    public $homocide;
    public $violenceWithInjury;
    public $violenceWithoutInjury;
    public $sexualOffenses;
    public $robbery;
    public $theftOffenses;
    public $domesticBurglary;
    public $nonDomesticBurglary;
    public $vehicleOffenses;
    public $theftFromPerson;
    public $bicycleTheft;
    public $shoplifting;
    public $miscTheft;
    public $criminalDamageAndArson;
    public $drugOffenses;
    public $possesionOfWeapons;
    public $publicOrderOffenses;
    public $miscCrimes;
    public $fraud;

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
