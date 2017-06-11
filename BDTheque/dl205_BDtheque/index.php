<?php
    // Import de la bibliothèque contenant l'initialisation des variables
    // modifiables par le client
    include_once 'ini/bdtheque.inc.php';

    // Initialisation des variables
    $sPage = "";            // Page d'accueil par défaut
    $sMenuOK = false;       // Pas de menu par défaut
    $sTitre = "%%";         // Initialisation à vide pour la recherche des BD par les titres 
    $sAuteur = "%%";        // Initialisation à vide pour la recherche des BD par les auteurs
    $sTheme = "%%";         // Initialisation à vide pour la recherche des BD par les themes

    // Récupération du choix de l'utilisateur
    if (isset($_GET['choix'])) {
        $sChoix = $_GET['choix'];
    }
    // Si le choix n'est pas trouvé dans le $_GET, on initialise à accueil => valeur par défaut
    else {
        $sChoix = "accueil";
    }
    
    // Traitement en fonction du choix de l'utilisateur
    switch ($sChoix) {
        case "recherche_BD" :
            // Ouverture de la session
            session_start();
            
            // Pour toute nouvelle recherche
            if (isset($_GET['recherche'])) {
                // Récupération des champs de saisie
                $_SESSION['recherche_titre'] = "%".$_POST['recherche_titre']."%";
                $_SESSION['recherche_auteur'] = "%".$_POST['recherche_auteur']."%";
                $_SESSION['recherche_theme'] = "%".$_POST['recherche_theme']."%";
            }

            // Attribution des valeurs aux variables
            $sTitre = $_SESSION['recherche_titre'];
            $sAuteur = $_SESSION['recherche_auteur'];
            $sTheme = $_SESSION['recherche_theme'];

        case "liste_BD" :
            if (!session_id()) {
                session_start();
                
                // Réinitialisation des variables pour le fil d'ariane
                $_SESSION['recherche_titre'] = "%%";
                $_SESSION['recherche_auteur'] = "%%";
                $_SESSION['recherche_theme'] = "%%";
            }
            
            // Import des managers et du fichier pour générer le fil d'ariane
            include_once 'model/ThemeManager.class.php';
            include_once 'model/BandeDessineeManager.class.php';
            include_once 'model/filAriane.inc.php';
            include_once 'model/miniature.inc.php';

            // Lancement des managers
            $sManBD = new BandeDessineeManager();
            $sManTheme = new ThemeManager();

            // Si l'utilisateur est déjà sur une page de la liste
            // => récupération de la limite
            if (isset($_GET['limite'])) {
                $sLimite = intval($_GET['limite']);
            }
            // Sinon => initialisation à 0
            else {
                $sLimite = 0;
            }

            // Récupération des BD à afficher
            $tBD = $sManBD->getListeLimiteBD($sLimite, $sNbBD, $sTitre, $sAuteur, $sTheme);

            // Récupération des thèmes liés aux BD à afficher
            // S'il y a des BD enregistrées dans le tableau de BD
            // => récupération des thèmes correspondants
            if ($tBD) {
                for ($i = 0; $i < sizeof($tBD); $i++) {
                    $tTheme[] = $sManTheme->getThemeBD($tBD[$i]->getId());
                }
            }
            // Sinon initialisation du tableau de thème à 0
            else {
                $tTheme = 0;
            }

            // Création des miniatures si elles n'existent pas
            if ($tBD) {
                foreach ($tBD as $sBD) {
                    if (!file_exists("img/miniBD/".$sBD->getImage())) {
                        creaMiniBD($sBD->getImage());
                    }
                }
            }
            
            // Fermeture des managers
            $sManBD = null;
            $sManTheme = null;

            // Page à afficher
            $sPage = "view/list_BD.php";

            // Affichage du menu
            $sMenuOK = true;
            break;

        case "consult_BD" :
            // Ouverture de la session
            session_start();
             
            // Import des managers
            include_once 'model/ThemeManager.class.php';
            include_once 'model/BandeDessineeManager.class.php';
            include_once 'model/CommentaireManager.class.php';

            // Lancement des managers
            $sManBD = new BandeDessineeManager();
            $sManTheme = new ThemeManager();
            $sManCom = new CommentaireManager();

            // Récupération de l'identifiant de la BD sélectionnée
            if (isset($_GET['idBD'])) {
                $sIdBD = $_GET['idBD'];
            }

            // Récupération des informations de la BD
            $sBD = $sManBD->getInfoBD($sIdBD);

            // Récupération des thèmes liés à la BD
            $sTheme = $sManTheme->getThemeBD($sIdBD);

            // Récupération des commentaires liés à la BD
            $tCom = $sManCom->getComBD($sIdBD);

            // Fermeture des managers
            $sManBD = null;
            $sManTheme = null;
            $sManCom = null;

            // Page à afficher
            $sPage = "view/consult_BD.php";

            // Affichage du menu
            $sMenuOK = true;
            break;
            
        case "nouveau_com" :
            // Importation des classes concernant les commentaires
            include_once 'model/Commentaire.class.php';
            include_once 'model/CommentaireManager.class.php';
            
            // Récupération de la saisie de l'utilisateur
            if (isset($_POST['pseudo'])) {
                $sIdBD = $_POST['idBd'];
                $sPseudo = $_POST['pseudo'];
                $sTextCom = $_POST['texte'];
            }
            
            // Création du commentaire à insérer
            $sNouveauCom = new Commentaire(null,
                                           $sIdBD,
                                           "",
                                           $sPseudo,
                                           $sTextCom,
                                           0);
            
            // Lancement du manager
            $sManCom = new CommentaireManager();
            
            // Insertion du commentaire dans la DB
            $sInsertOK = $sManCom->insertCom($sNouveauCom);
            
            // Fermeture du manager
            $sManCom = null;
            
            // Redirection vers la page de consultation
            header('location: index.php?choix=consult_BD&idBD='.$sIdBD.'&insertion='.$sInsertOK.'');
            break;

        case "verif_co_admin" :
            // Ouverture de la session
            session_start();
            
            // Import des classes en lien avec les comptes
            include_once 'model/Compte.class.php';
            include_once 'model/CompteManager.class.php';

            // Récupération de la saisie
            if (isset($_POST['saisie_id'])) {
                $sId = $_POST['saisie_id'];
                $sMdp = $_POST['saisie_mdp'];
            }

            // Création du compte
            $sCompteSaisi = new Compte($sId, $sMdp);

            // Lancement du manager
            $sManCompte = new CompteManager();

            // Vérification si le compte est trouvé dans la DB
            $sCompteTrouve = $sManCompte->verifCompte($sCompteSaisi);

            // Fermeture du manager
            $sManCompte = null;

            // Si l'identifiant et le mot de passe correspondent bien à un compte de la DB
            // => Récupération des données dans la session
            if ($sCompteTrouve) {
                $_SESSION['id'] = $sCompteSaisi->getId();
                $_SESSION['mdp'] = $sCompteSaisi->getMdp();

                header("location: index.php?choix=accueil_admin");
            }
            // Sinon, réaffichage de la page d'accueil avec message d'alerte
            else {
                header("location: index.php?choix=accueil&refus_co=1");
            }
            break;

        case "accueil_admin" :
            // Ouverture de la session
            session_start();
            
            // Vérification si la connexion en tant qu'admin est effective
            if (isset($_SESSION['id'])) {
                // Import du manager de commentaire
                include_once 'model/CommentaireManager.class.php';

                // Lancement du manager
                $sManCom = new CommentaireManager();

                // Récupération des commentaires à modérer
                $tComAValider = $sManCom->getComAValider();

                // Page à afficher
                $sPage = "view/accueil_admin.php";

                // Affichage du menu
                $sMenuOK = true;
            }
            // Sinon, message d'avertissment
            else {
                header('location: index.php?choix=erreur');
            }
            break;
        
        case "gestion_com" :
            // Ouverture de la session
            session_start();
            
            // Vérification si la connexion en tant qu'admin est effective
            if (isset($_SESSION['id'])) {
                // Import du manager de commentaire
                include_once 'model/CommentaireManager.class.php';

                // Lancement du manager
                $sManCom = new CommentaireManager();

                // Récupération des commentaires à modérer
                $tComAValider = $sManCom->getComAValider();

                // Fermeture du manager
                $sManCom = null;

                // Page à afficher
                $sPage = "view/gestion_com.php";

                // Affichage du menu
                $sMenuOK = true;
            }
            // Sinon, message d'avertissment
            else {
                header('location: index.php?choix=erreur');
            }
            break;
        
        case "mod_com" :
            // Ouverture de la session
            session_start();
            
            // Vérification si la connexion en tant qu'admin est effective
            if (isset($_SESSION['id'])) {
                // Si l'admin a bien fait un choix
                if (isset($_POST['moderation_com'])) {
                    // Récupération de la valeur du bouton radio
                    $sAction = $_POST['moderation_com'];

                    // Récupération de l'identifiant du commentaire
                    $sIdCom = $_POST['id_com_modere'];

                    // Import du manager des commentaires
                    include_once 'model/CommentaireManager.class.php';

                    // Lancement du manager
                    $sManCom = new CommentaireManager();

                    if ($sAction === "Accepter") {
                        // Demande d'ajout à la BDthèque
                        $sActionOK = $sManCom->validerCom($sIdCom);

                        // Redirection
                        header('location: index.php?choix=gestion_com&msg='.$sActionOK);
                    }
                    else if ($sAction === "Modifier") {
                        // Récupération du texte modifié par l'admin
                        $sTexte = $_POST['texte_com_modere'];
                        $sActionOK = $sManCom->modifierCom($sIdCom, $sTexte);

                        // Redirection
                        // Redirection
                        header('location: index.php?choix=gestion_com&msg='.$sActionOK);
                    }
                    else if ($sAction === "Supprimer") {
                        $sActionOK = $sManCom->supprimerCom($sIdCom);

                        // Redirection
                        // Redirection
                        header('location: index.php?choix=gestion_com&msg='.$sActionOK);
                    }

                    // Fermeture du manager
                    $sManCom = null;
                }
                // Sinon => message d'information avertissant qu'il faut choisir
                else {
                    header('location: index.php?choix=gestion_com&selectOK=false');
                }
            }
            // Sinon, message d'avertissment
            else {
                header('location: index.php?choix=erreur');
            }
            break;
        
        case "gestion_auteur" :
            // Ouverture de la session
            session_start();
            
            // Vérification si la connexion en tant qu'admin est effective
            if (isset($_SESSION['id'])) {
                // Import du manager de thème
                include_once 'model/AuteurManager.class.php';

                // Lancement du manager
                $sManAuteur = new AuteurManager();

                // Récupération de tous les thèmes de la DB
                $tAuteur = $sManAuteur->getListAuteur();

                // Page à afficher
                $sPage = "view/gestion_auteur.php";

                // Affichage du menu
                $sMenuOK = true;
            }
            // Sinon, message d'avertissment
            else {
                header('location: index.php?choix=erreur');
            }
            break;
            
        case "verif_gest_aut" :
            // Ouverture de la session
            session_start();
            
            // Vérification si la connexion en tant qu'admin est effective
            if (isset($_SESSION['id'])) {
                // Import des classes
                include_once 'model/AuteurManager.class.php';
                include_once 'model/Auteur.class.php';

                // Lancement du manager
                $sManAuteur = new AuteurManager();
                
                // Récupération de la saisie
                if (isset($_POST['nouveau_nom'])) {
                    $sNom = $_POST['nouveau_nom'];
                    $sId = intVal($_POST['gestion_auteur']);
                }

                // Récupération de l'action de l'administrateur
                // Si ajouter ET que la sélection du menu déroulant est bien Nouvel auteur
                if (isset($_POST['ajouter']) && $sId === 0) {
                    // Création de l'auteur
                    $sNouvelAuteur = new Auteur($sNom);
                    
                    // Vérification si l'auteur existe déjà dans la DB
                    if (!$sManAuteur->verifAuteur($sNouvelAuteur)){
                        // Envoi de la demande d'ajout
                        $sAjoutOK = $sManAuteur->ajouterAuteur($sNouvelAuteur);

                        // Redirection
                        header('location: index.php?choix=gestion_auteur&insert='.$sAjoutOK);
                    }
                    else {
                        header('location: index.php?choix=gestion_auteur&insert=existant');
                    }
                }
                // Si modifier ET que la sélection du menu déroulant n'est pas Nouvel auteur
                else if (isset($_POST['modifier']) && $sId !== "") {
                    // Création de l'auteur
                    $sAuteur = new Auteur($sId,
                                          $sNom);
                    
                    // Envoi de la demande de modification
                    $sModifOK = $sManAuteur->modifierAuteur($sAuteur);
                    
                    // Redirection
                    header('location: index.php?choix=gestion_auteur&update='.$sModifOK);
                }
                // Sinon => avertissement d'une erreur
                else {
                    header('location: index.php?choix=gestion_auteur&erreur=1');
                }
            }
            // Sinon, message d'avertissment
            else {
                header('location: index.php?choix=erreur');
            }
            break;
        
        case "gestion_theme" :
            // Ouverture de la session
            session_start();
            
            // Vérification si la connexion en tant qu'admin est effective
            if (isset($_SESSION['id'])) {
                // Import des classes
                include_once 'model/ThemeManager.class.php';
                include_once 'model/Theme.class.php';

                // Lancement du manager
                $sManTheme = new ThemeManager();

                // Récupération de tous les thèmes de la DB
                $tTheme = $sManTheme->getListTheme();

                // Page à afficher
                $sPage = "view/gestion_theme.php";

                // Affichage du menu
                $sMenuOK = true;
            }
            // Sinon, message d'avertissment
            else {
                header('location: index.php?choix=erreur');
            }
            break;
            
        case "verif_gest_theme" :
            // Ouverture de la session
            session_start();
            
            // Vérification si la connexion en tant qu'admin est effective
            if (isset($_SESSION['id'])) {
                // Import du manager de thème
                include_once 'model/ThemeManager.class.php';

                // Lancement du manager
                $sManTheme = new ThemeManager();
                
                // Récupération de la saisie
                if (isset($_POST['nouvel_intitule'])) {
                    $sIntitule = $_POST['nouvel_intitule'];
                    $sId = intVal($_POST['gestion_theme']);
                }

                // Récupération de l'action de l'administrateur
                // Si ajouter ET que la sélection du menu déroulant est bien Nouveau thème
                if (isset($_POST['ajouter']) && $sId === 0) {
                    // Création du thème
                    $sNouveauTheme = new Theme($sIntitule);
                    
                    // Vérification si le thème existe déjà
                    if (!$sManTheme->verifTHeme($sNouveauTheme)) {
                        // Envoi de la demande d'ajout
                        $sAjoutOK = $sManTheme->ajouterTheme($sNouveauTheme);

                        // Redirection
                        header('location: index.php?choix=gestion_theme&insert='.$sAjoutOK);
                    }
                    else {
                        // Redirection
                        header('location: index.php?choix=gestion_theme&insert=existant');
                    }
                }
                // Si modifier ET que la sélection du menu déroulant n'est pas Nouveau thème
                else if (isset($_POST['modifier']) && $sId !== "") {
                    // Création de l'auteur
                    $sTheme = new Theme($sId,
                                        $sIntitule);
                    
                    // Envoi de la demande de modification
                    $sModifOK = $sManTheme->modifierTheme($sTheme);
                    
                    // Redirection
                    header('location: index.php?choix=gestion_theme&update='.$sModifOK);
                }
                // Sinon => avertissement d'une erreur
                else {
                    header('location: index.php?choix=gestion_theme&erreur=1');
                }
            }
            // Sinon, message d'avertissment
            else {
                header('location: index.php?choix=erreur');
            }
            break;
            
        case "gestion_BD" :
            // Ouverture de la session
            session_start();
            
            // Vérification si la connexion en tant qu'admin est effective
            if (isset($_SESSION['id'])) {
                // Import des classes
                include_once 'model/ThemeManager.class.php';
                include_once 'model/AuteurManager.class.php';
                
                // Lancement des managers
                $sManTheme = new ThemeManager();
                $sManAuteur = new AuteurManager();
                
                // Récupération des thèmes
                $tTheme = $sManTheme->getListTheme();
                
                //récupération des auteurs
                $tAuteur = $sManAuteur->getListAuteur();
                
                // Page à afficher
                $sPage = "view/gestion_bd.php";

                // Affichage du menu
                $sMenuOK = true;
            }
            // Sinon, message d'avertissment
            else {
                header('location: index.php?choix=erreur');
            }
            break;
        
        case "verif_ajout_BD" :
            // Ouverture de la session
            session_start();
            
            // Import du manager de BD
            include_once 'model/BandeDessineeManager.class.php';
            
            // Lancement du manager
            $sManBD = new BandeDessineeManager();
            
            // Vérification si la connexion en tant qu'admin est effective
            if (isset($_SESSION['id'])) {
                // Si le post existe
                if (isset($_POST['titre_BD'])) {
                    // Récupération des saisies
                    $sTitreBD = $_POST['titre_BD'];
                    $sResumeBD = $_POST['resume_BD'];
                    $sImageBD = $_POST['image_BD'];
                    $sAuteurBD = $_POST['auteur_BD'];
                    
                    // Création de la nouvelle BD
                    $sNouvelleBD = new BandeDessinee(null,
                                                     $sTitreBD,
                                                     $sResumeBD,
                                                     $sImageBD,
                                                     $sAuteurBD);
                    
                    $sInsertOK = $sManBD->ajoutBD($sNouvelleBD);
                    
                    // Redirection
                    header('location: index.php?choix=gestion_BD&ajoutBD='.$sInsertOK);
                }
            }
            // Sinon, message d'avertissment
            else {
                header('location: index.php?choix=erreur');
            }
            break;    
            
        case "deconnexion" :
            // Ouverture de la session
            session_start();
            
            // Vérification si la connexion en tant qu'admin est effective
            if (isset($_SESSION['id'])) {
                // Fermeture de la session
                session_unset();
                session_destroy();

                // Page à afficher
                $sPage = "view/accueil.php";
            }
            // Sinon, message d'avertissment
            else {
                header('location: index.php?choix=erreur');
            }
            break;
        
        case "erreur" :
            // Page à afficher
            $sPage = "view/erreur.php";
            break;

        default:
            // Ouverture de la session
            session_start();
            
            $sPage = "view/accueil.php";
            break;
    }

    // Affichage du contenu de la page
    require 'view/header.php';
    if ($sMenuOK) {
        require 'view/menu.php';
    }
    require($sPage);
    require('view/footer.php');
?>