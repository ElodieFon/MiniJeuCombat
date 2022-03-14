<?php  
/*Fonction d'autochargement de l'ensemble des classes*/
function chargerMesClasses($classes) 
{
    require 'classes/' . $classes . '.php';
}
spl_autoload_register('chargerMesClasses');

// Démarrage de la session
session_start(); 

// destruction de la session
if (isset($_GET['deconnexion'])) 
{
    session_destroy();
    header('Location: .');
    exit();
}
// Si la session perso existe, on restaure l'objet
if (isset($_SESSION['perso'])) {
    $perso = $_SESSION['perso'];
}

$bdd = new PDO('mysql:host=localhost;dbname=minijeucombat', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$reposit = new persoRepository($bdd);

// Si souhait création personnage
if (isset($_POST['creer']) && isset($_POST['personnageNom']))
{
    switch ($_POST['personnageType']) {
        case 'magicien' :
            $perso = new Magicien(['nom' => $_POST['personnageNom']]);
        break;

        case 'guerrier' :
            $perso = new Guerrier(['nom' => $_POST['personnageNom']]);
        break;
        case 'chasseur' :
            $perso = new Chasseur(['nom' => $_POST['personnageNom']]);
        break;

        default :
            $message = '<img src="https://img.icons8.com/external-nawicon-flat-nawicon/40/000000/external-warning-construction-nawicon-flat-nawicon.png"/>
            Le type du personnage n\'est pas valide ';
            unset($perso);
        break;
    }
    
    // Si le type du personnage est valide - le perdsonnage est créé
    if(isset($perso))
    {
        if (!$perso->validName())
        {
            $message = 'Le nom choisi n\'est pas valide.';
            unset($perso);
        }
        
        elseif ($reposit->ifPersonnageExist($perso->getNom()))
        {
            $message = ' <img src="https://img.icons8.com/external-nawicon-flat-nawicon/40/000000/external-warning-construction-nawicon-flat-nawicon.png"/>
            Le nom du personnage est déjà utilisé.';    
            unset($perso);
        }
        
        else
        {
            $reposit->addPersonnage($perso);
            $message = 'Le personnage est créé.';
        }
    }
}

elseif (isset($_POST['utiliser']) && isset($_POST['personnageNom'])) // Si souhait utilisation d'un personnage existant
{
    if ($reposit->ifPersonnageExist($_POST['personnageNom'])) // SI le personnage existe
    {
        $perso = $reposit->getPersonnage($_POST['personnageNom']);
    }
    else
    {
        $message = '<p class="bg-danger col-4 text-center">
        <img src="https://img.icons8.com/external-nawicon-flat-nawicon/40/000000/external-warning-construction-nawicon-flat-nawicon.png"/>
        Ce personnage n\'existe pas 
        <img src="https://img.icons8.com/external-nawicon-flat-nawicon/40/000000/external-warning-construction-nawicon-flat-nawicon.png"/></p>'; // Message si le personnage n'existe pas
    }
}

// Si on clique sur un personnage pour le frapper
elseif (isset($_GET['frapperUnPersonnage']))
{
    if (!isset($perso))
    {
        $message = 'Merci de créer un personnage ou de vous identifier';
    }
    
    else
    {
        if (!$reposit->ifPersonnageExist((int) $_GET['frapperUnPersonnage']))
        {
            $message = '<img src="https://img.icons8.com/external-nawicon-flat-nawicon/40/000000/external-warning-construction-nawicon-flat-nawicon.png"/>
            Le personnage que vous voulez attaquer n\'existe pas ';
        }
        
        else
        {
            $persoAFrapper = $reposit->getPersonnage((int) $_GET['frapperUnPersonnage']);
            
            // Gestion d'affichage des erreurs renvoyés par la méthode frapperUnPersonnage
            $retour = $perso->frapperUnPersonnage($persoAFrapper);
            
            switch ($retour)
            {
                case Personnage::DETECT_ME :
                    $message = 'Mais...c\'est moi !!!';                   
                break;
                
                case Personnage::PERSO_COUP :
                    $message = '<img src="https://img.icons8.com/color/48/000000/megaphone.png"/>
                    << Le personnage a bien été atteint !';    
                    $reposit->updatePersonnage($perso);
                    $reposit->updatePersonnage($persoAFrapper);  
                break;
                
                case Personnage::PERSO_DEAD :
                    $message = '<img src="https://img.icons8.com/officel/50/000000/coffin.png"/>Vous avez tué ce personnage !';                   
                    $reposit->updatePersonnage($perso);
                    $reposit->deletePersonnage($persoAFrapper);
                break;
                
                case Personnage::PERSO_dore :
                    $message = 'Vous êtes endormi et ne pouvez pas frapper un adversaire';
                break;
            }
        }
    }
}

// Si le personnage est un magicien et qu'il veut lancer un sort
elseif (isset($_GET['Endormir']))
{
    if (!isset($perso))
    {
        $message = 'Merci de créer une personnage ou de vous identifier';
    }
    
    else
    {
        // Vérifier si personnage est un Magicien
        if ($perso->getType() != 'magicien')
        {
            $message = '<p class="bg-danger text-light">Vous n\'êtes pas magicien...Vous ne pouvez pas endormir l\'adversaire </p>';
        }
        
        else
        {
            if (!$reposit->ifPersonnageExist((int) $_GET['Endormir']))
            {
                $message = 'Le personnage que vous voulez endormir n\'existe pas';
            }
            
            else
            {
                $persoAEndormir = $reposit->getPersonnage((int) $_GET['Endormir']);
                $retour = $perso->Endormir($persoAEndormir);
                
                switch ($retour)
                {
                    case Personnage::DETECT_ME :
                        $message = 'Stupid idiot...Je ne peux m\'Endormir !';               
                    break;
                    
                    case Personnage::PERSO_ENDORMI :
                        $message = '<img src="https://img.icons8.com/color/48/000000/megaphone.png"/>
                        << Vous avez endormi votre adversaire';
                        
                        $reposit->updatePersonnage($perso);
                        $reposit->updatePersonnage($persoAEndormir);                       
                    break;
                    
                    case Personnage::NO_MAGIE :
                        $message = 'Vous n\'avez pas assez de magie !';                        
                    break;
                    
                    case Personnage::PERSO_dore :
                        $message = 'Vous êtes endormi, vous ne pouvez pas lancer de sort !';                        
                    break;
                }
            }
        }
    }
}
// Si création d'un personnage alors stockage dans une variable SESSION
if (isset($perso)) 
{
    $_SESSION['perso'] = $perso;   
}
?>