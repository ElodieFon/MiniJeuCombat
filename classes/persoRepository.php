<?php
class persoRepository 
{
    private $bdd; // Instance de PDO

    /* Méthode de construction*/
     
    public function __construct($bdd) 
    {
        $this->setDb($bdd);
    }
    
    /*Méthodes Mutateurs (Setters) - Pour modifier la valeur des attributs*/
   
    public function setDb(PDO $bdd) 
    {
        $this->bdd = $bdd;
    }
    
    /*  Methode d'insertion d'un personnage dans la BDD*/
     
    public function addPersonnage(Personnage $perso) 
    {
        $req = $this->bdd->prepare('INSERT INTO personnages SET nom = :nom, type = :type');
                                         
        $req->bindValue(':nom', $perso->getNom(), PDO::PARAM_STR); 
        $req->bindValue(':type', $perso->getType(), PDO::PARAM_STR);    
        $req->execute();
   
        $perso->hydrate([
            'id' => $this->bdd->lastInsertId(),
            'degats' => 0,
            'atout' => 0
        ]);   
        $req->closeCursor(); 
    }
    
    // Methode de mise à jour / modification d'un personnage dans la BDD
    public function updatePersonnage(Personnage $perso) 
    {
      
        $req = $this->bdd->prepare('UPDATE personnages SET degats = :degats, dodo = :dodo, atout = :atout WHERE id = :id'); 

        $req->bindValue(':degats', $perso->getDegats(),PDO::PARAM_INT);
        $req->bindValue(':dodo', $perso->getdodo(), PDO::PARAM_INT);
        $req->bindValue(':atout', $perso->getAtout(), PDO::PARAM_INT);
        $req->bindValue(':id', $perso->getId(), PDO::PARAM_INT);   

        $req->execute();     
        $req->closeCursor();
    }
    
    // Methode de suppression d'un personnage dans la BDD
    public function deletePersonnage(Personnage $perso) 
    {
        $this->bdd->exec('DELETE FROM personnages WHERE id = ' . $perso->getId());
                                 
    }
    
    //Methode de selection d'un personnage avec clause WHERE
    public function getPersonnage($info) 
    {   
        if (is_int($info)) 
        {
            $req = $this->bdd->query('SELECT id, nom, degats, dodo, type, atout FROM personnages WHERE id = ' . $info);                           
            $datasOfPerso = $req->fetch(PDO::FETCH_ASSOC);
        }    
        else 
        {
            $req = $this->bdd->prepare('SELECT id, nom, degats, dodo, type, atout FROM personnages WHERE nom = :nom');                             
            $req->execute([':nom' => $info]);    
            $datasOfPerso = $req->fetch(PDO::FETCH_ASSOC);
        }
        switch ($datasOfPerso['type']) 
        {
            case 'guerrier' : return new Guerrier($datasOfPerso);
            case 'magicien' : return new Magicien($datasOfPerso);
            case 'chasseur' : return new Chasseur($datasOfPerso);
            default : return null;
        }
        $req->closeCursor(); 
    }

    // Methode de selection de toute la liste des personnages
    public function getListPersonnages($nom) 
    { 
        $persos = [];
        $req = $this->bdd->prepare('SELECT id, nom, degats, dodo, type, atout FROM personnages WHERE nom <> :nom ORDER BY nom');                           
        $req->execute([':nom' => $nom]);  

        while ($datas = $req->fetch(PDO::FETCH_ASSOC)) 
        {
            switch ($datas['type']) 
            {
                case 'guerrier' : $persos[] = new Guerrier($datas);
                    break;
                case 'magicien' : $persos[] = new Magicien($datas);
                    break;
                 case 'chasseur' : $persos[] = new Chasseur($datas);
                    break;
            }
        }   
        return $persos;   
        $req->closeCursor(); 
    }
    
    // Méthode pour compter le nombre de personnage
    public function countPersonnages() 
    {
        return $this->bdd->query('SELECT COUNT(*) FROM personnages')->fetchColumn();                                 
    }
    
    // Méthode pour déterminer si un personnage exist
    public function ifPersonnageExist($info) 
    {
        if (is_int($info)) 
        {
            return (bool) $this->bdd->query('SELECT COUNT(*) FROM personnages WHERE id = ' . $info)->fetchColumn();                                       
        }
        $req = $this->bdd->prepare('SELECT COUNT(*) FROM personnages WHERE nom = :nom');                                   
        $req->execute([':nom' => $info]);

        return (bool) $req->fetchColumn();      
        $req->closeCursor();
    }
}