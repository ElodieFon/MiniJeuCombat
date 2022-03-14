<?php
abstract class Personnage {
    /*
     * Attributs
     */
    protected $id;
    protected $nom;
    protected $degats;
    protected $dodo;
    protected $type;
    protected $atout;
    
    
    /*
     * Déclaration des constantes
     */
    const DETECT_ME     = 1; // Constante renvoyée par la méthode frapperUnPersonnage - détecte si on se frappe soi-même grace au code 1
    const PERSO_DEAD    = 2; // Constante renvoyée par la méthode frapperUnPersonnage - détecte si un personnage est tué en le frappant grace au code 2
    const PERSO_COUP    = 3; // Constante renvoyée par la méthode frapperUnPersonnage - détecte si un coup est bien porté à un personnage grace au code 3
    const PERSO_ENDORMI = 4; // Constante renvoyée par la méthode Endormir - détecte si le sort est bien lancé grace au code 4
    const NO_MAGIE      = 5; // Constante renvoyée par la méthode Endormir - détecte si magie du magicien à 0 grace au code 5
    const PERSO_dore    = 6; // Constante renvoyé par la méthode frapperUnPersonnage - détecte si le personnage qui veut frapper est ENDORMI grace au code 6


    /*
     * Méthode de construction
     */
    public function __construct(array $datas) 
    {
        $this->hydrate($datas);
        $this->type = strtolower(static::class);
    }
    
    
    /*
     * Methode d'hydratation
     */
    public function hydrate(array $datas) 
    {
        foreach ($datas as $key => $value) 
        {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method)) 
            {
                $this->$method($value);
            }
        }
    }
     
    /*
     * Méthodes génériques
     */
    // Methode frapper un personnage
    public function frapperUnPersonnage(Personnage $persoAFrapper) {
        if ($persoAFrapper->getId() == $this->id) {
            return self::DETECT_ME;
        }
        
        if ($this->ENDORMI()) {
            return self::PERSO_dore;
        }
        
        // Indication au personnage qu'il reçoit un coup / des dégats
        // Puis on retourne la valeur renvoyée par la méthode : self::PERSONNAGE_TUE ou self::PERSONNAGE_FRAPPE
        return $persoAFrapper->recevoirUnCoup();
    }
    
    // Methode de gestion de réception d'un coup, d'un dégat
    // Augmentation des dégats par 5 - à 100 de dégats ou plus le personnage est mort
    public function recevoirUnCoup() {
        $this->degats += 5;
        
        // 100 ou plus de dégats => le personnage est tué
        if ($this->degats >= 100) {
            return self::PERSO_DEAD;
        }
        
        // Le personnage reçoit un coup
        return self::PERSO_COUP;
    }
    
    // Methode qui détermine si le nom du personnage est valide - champ non vide
    public function validName() {
        // return bool - True or False
        return !empty($this->nom);
    }
    
    // Methode qui détermine si le personnage est ENDORMI
    public function ENDORMI() {
        return $this->dodo > time();
    }
    
    // Methode de gestion du temps
    public function reveil() {
        $secondes = $this->dodo;
        $secondes -= time();
        
        $heures = floor($secondes / 3600);
        $secondes -= $heures * 3600;
        $minutes = floor($secondes / 60);
        $secondes -= $minutes * 60;
        
        $heures .= $heures <= 1 ? ' heure' : ' heures';
        $minutes .= $minutes <= 1 ? ' minute' : ' minutes';
        $secondes .= $secondes <= 1 ? ' seconde' : ' secondes';
        
        return $heures . ', ' . $minutes . ' et ' . $secondes;
    }
    
    
    /*
     * Méthodes Accesseurs (Getters) - Pour récupérer / lire la valeur d'un attribut
     */
    public function getId() {
        return $this->id;
    }
    
    public function getNom() {
        return $this->nom;
    }
    
    public function getDegats() {
        return $this->degats;
    }
    
    public function getdodo() {
        return $this->dodo;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function getAtout() {
        return $this->atout;
    }
    
    
     /*
      * Methodes Mutateurs (Setters) - Pour modifier la valeur d'un attribut
      * 
      * Pas de setter pour $_type car le type du personnage est constant - le magicien ne peut se tranfromer en guerrier
      * Le type est défini dans le constructeur
      */
     public function setId($id) {
         $this->id = (int)$id; // Pas de vérification - ID est obligatoirement un entier strictement positif
     }
     
     public function setNom($nom) {
         if (is_string($nom)) {     // Vérification si présence d'une chaîne de caractères
             $this->nom = $nom;    // On assigne alors la valeur $nom à l'attribut _nom
         }
     }
     
     public function setDegats($degats) {
         $degats = (int)$degats; // Conversion de l'argument en nombre entier
         // Vérification - Le nombre doit être strictemeznt positif et compris entre 0 et 100
         if ($degats >= 0 && $degats <= 100) {
             $this->degats = $degats; // on assigne alors la valeur $degats à l'attribut _degats
         }
     }
     
     public function setdodo($time) {
         $this->dodo = (int) $time;
     }
     
     public function setAtout($atout) {
         $atout = (int) $atout;
         
         if ($atout >= 0 && $atout <= 100) {
             $this->atout = $atout;
         }
     }
    
}