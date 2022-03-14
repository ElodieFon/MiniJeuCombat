<?php

// inclure le fichier de gestion
include ('gestion.php');
?>
<!DOCTYPE html>
<html lang="fr-FR">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">                
        <title>Mini jeu de combat</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >      
        <link rel="stylesheet" type="text/css"  href="css/style.css" media="all">               
    </head>
    <body class="">
        <div class="container d-flex flex-wrap justify-content-center align-items-center align-content-evenly h-100">
       
            <header class="col-12">
                <h1 class="text-center">Mini jeu de combat</h1>
            </header>
               
            <section id="infos" class="row col-sm-12 d-flex justify-content-center mt-3">
                <p class="bouton bg-warning col-6 text-center">Nombre de personnage restant : 
                    <span class="bouton  border-danger p-1 bg-light text-dark">
                        <strong><?= $reposit->countPersonnages() ?></strong>
                    </span> 
                </p>
                <p>
                    <?php
                    // Si message à afficher
                        if (isset($message)) 
                        {  
                            echo $message; // on affiche le message
                        }
                    ?>
                </p>
            </section>
             
            <?php
            // Si utilisation d'un personnage
                if (isset($perso)) 
                {
            ?>
                <div class="d-flex col-12  justify-content-end">
                    <a class="btn btn-danger text-light mb-3" href="?deconnexion=1">Changer de perso</a>
                </div>

                <section class="row col-sm-12 ">

                    <div class="d-flex w-100 justify-content-evenly block-info ">
                        <div class="information bg-dark text-light rounded-3 p-3 m-3">
                            
                            <h4> Informations du personnage </h4>

                            <p>
                                Nom : <?= htmlspecialchars($perso->getNom()) ?><br>
                                Dégâts subit : <?= $perso->getDegats() ?><br>
                                Type : <?= ucfirst($perso->getType()) ?>
                                <br>

                                <?php
                                // Affichage Atout du personnage selon son type
                                switch ($perso->getType()) 
                                {
                                    case 'guerrier' :
                                        echo 'Protection : ';
                                    break;

                                    case 'magicien' :
                                        echo 'Magie : ';
                                    break;
                                    default :
                                    echo ' ';
                                }      
                                echo $perso->getAtout();
                                ?>
                            </p>
                        </div>

                        <div class="sticker m-3">
                        <?php 
                        // Affichage d'une image selon le type du perso
                            if ($perso->getType()=="magicien")
                            {
                                echo'<img src="images/magicienne.gif" style="width : 150px"/>';
                            }
                            else if ($perso->getType()=="guerrier")
                            {
                                echo'<img src="images/gerrière.gif" style="width : 150px"/>';
                            }
                            else if($perso->getType()=="chasseur"){
                                echo'<img src=""/>';
                                
                            }
                            ?>
                        </div>
                    </div>

                    <div>
                        <h4>Qui frapper ?</h4>
                       
                        <?php
                            // Récupérer la liste de tous les personnages par ordre alphabétique dont le nom est différent du personnage choisi
                            $persos = $reposit->getListPersonnages($perso->getNom());
                            if (empty($persos)) 
                            {
                                echo 'Il n\'y aucun adversaire';
                            }
                            else 
                            {
                                if ($perso->endormi()) 
                                {
                                    echo 'Un magicien vous a endormi ! Vous allez vous réveiller dans ' . $perso->reveil() . '.';
                                }
                                else 
                                {
                                    foreach ($persos as $onePerson) 
                                    {
                                        echo 
                                        '<table class="bg-dark text-light table">                                              
                                            <tr>'; 
                                                if ($onePerson ->getType()=="magicien")
                                                {
                                                    echo
                                                    '<td class="col-1 border-end  text-center"> 
                                                    <img src="https://img.icons8.com/color/50/000000/wizard.png"/>
                                                    </td>';
                                                }
                                                if ($onePerson ->getType()=="guerrier")
                                                {
                                                    echo
                                                    '<td class="col-1 border-end text-center"> 
                                                    <img src="https://img.icons8.com/officel/50/000000/armored-helmet.png"/>
                                                    </td>';
                                                }
                                                if ($onePerson ->getType()=="chasseur")
                                                {
                                                    echo
                                                    '<td class="col-1 border-end text-center"> 
                                                    <img src="https://img.icons8.com/color/48/000000/legolas.png"/>
                                                    </td>';
                                                }
                                                echo'
                                                <td class="border-end text-center">
                                                    '.ucfirst($onePerson->getNom()) .' '. 'type : ' .$onePerson->getType() .' ( Total Dégats : ' .$onePerson->getDegats()  . ' )
                                                </td>

                                                <td class="col-3 border-end text-center">
                                                    <a class="btn btn-warning text-light  bouton" href="?frapperUnPersonnage=' . $onePerson->getId() . '">' 
                                                        ."Frapper " . '
                                                    </a> ';
                                                    if ($perso->getType()=="guerrier")
                                                    {
                                                        echo '<img src="https://img.icons8.com/color/48/000000/armored-gauntlet.png"/>';
                                                    }
                                                    else if ($perso ->getType()=="magicien"){
                                                        echo '<img src="https://img.icons8.com/officel/48/000000/hockey-glove.png"/>';
                                                    }
                                                    else {
                                                        echo '<img src="https://img.icons8.com/color/48/000000/hand-skin-type-1.png"/>';
                                                    }
                                                echo 
                                                '</td>

                                                <td class="col-3 border-end text-center"> ';
                                                    if ($perso->getType()=="magicien")
                                                    {
                                                        echo'<a class="btn btn-info text-light  bouton" href="?Endormir=' . $onePerson->getId() . '">Endormir</a>
                                                        <img src="https://img.icons8.com/officel/50/000000/mage-staff.png"/>';                                                   
                                                    }
                                                    else 
                                                    {
                                                        echo'<a class="btn bg-secondary text-light  " href="?Endormir=' . $onePerson->getId() . '">Endormir</a>
                                                        '; 
                                                    }                
                                                    echo'
                                                </td>
                                            </tr>
                                        </table';                                                                                                        
                                    } 
                                }
                            }
                        ?>
                        
                    </div>
                </section>           
            <?php
            } 
            else 
            { // le formulaire s'affiche si il n'y a pas de personnage utilisé
            ?>   
                <section >
                    <form  method="post" class="d-flex flex-wrap align-content-around ">
                        
                        <div class="form-group  col-6 ">
                            <label for="personnageNom" class="col-xs-12 col-sm-4 col-md-9 control-label bg-dark mt-2 text-center text-light rounded-3 ">Nom du personnage : </label>
                            <div class="col-xs-12 col-sm-8 col-md-9 focus"> 
                                <input class="form-control input" type="text" name="personnageNom" id="prenom" placeholder="Nom du personnage" autofocus required />
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label for="personnageType" class="col-xs-12 col-sm-4 col-md-9 control-label bg-dark mt-2 text-center text-light rounded-3">Type du personnage : </label>
                            <div class="col-xs-12 col-sm-8 col-md-9">
                                <select class="form-control input" name="personnageType">
                                    <option value="magicien">Magicien</option>
                                    <option value="guerrier">Guerrier</option>
                                    <option value="chasseur">Chasseur</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-evenly align-center p-3">
                            <button type="submit" class="btn btn-primary text-light mt-2 bouton" value="Utiliser le personnage" name="utiliser">Utiliser le personnage</button>
                            <button type="submit" class="btn btn-success text-light mt-2 bouton" value="Créer le personnage" name="creer">Créer le personnage</button>
                        </div>

                    </form>

                </section>
            <?php
            }  
            ?>         
        </div>
    </body>
</html>

