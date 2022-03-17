<?php

class Magicien extends Personnage 
{
    public function Endormir(Personnage $persoAEndormir) 
    {
        if ($this->degats >= 0 && $this->degats <= 25) {
            $this->atout = 1;
        } elseif ($this->degats > 25 && $this->degats <= 50) {
            $this->atout = 2;
        } elseif ($this->degats > 50 && $this->degats <= 75) {
            $this->atout = 3;
        } elseif ($this->degats > 75 && $this->degats <= 90) {
            $this->atout = 4;
        } else {
            $this->atout = 0;
        }
        
        //comparaison
        if ($persoAEndormir->id == $this->id) {
            return self::DETECT_ME;
        }
        
        if ($this->atout == 0) {
            return self::NO_MAGIE;
        }
        
        if ($this->ENDORMI()) {
            return self::PERSO_dore;
        }
        
        $persoAEndormir->dodo = time() + ($this->atout * 6) *900;
        
        return self::PERSO_ENDORMI;
    }
   
    //TODO finir la fonction de clonage d'objet
    // function __clone()
    // {
    //     // Force la copie de personnageacloner, pour éviter qu'il pointe ver le meme objet
    
    //     $this->personnageacloner = clone $this->personageacloner;
    // }
}
