<?php
    // Import de la bibliothèque de connexion à la DB
    include_once 'model/db.inc.php';
    
    // Import de la classe BandeDessinee
    include_once 'model/BandeDessinee.class.php';
    
    class BandeDessineeManager {
        // Fonction :   getListeBD
        // Desc :       Permet de récupérer la liste des BD sélectionnées dans
        //              la table bandesdessinees de la DB cataloguebd, avec une limite
        //              de $sNbBD BD par page
        // IN :         $sNbBD (int) : nombre de BD à afficher par page
        // OUT :        $tBD (BandeDessinee) : tableau contenant toutes les BD à 
        //                      afficher sur la page en cours
        public function getListeLimiteBD($sLimite,$sNbBD,$sTitre,$sAuteur,$sTheme) {
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
             
            // Création de la requête
            // Si le thème est renseigné
            if ($sTheme !== "%%") {
                $sRequete = "SELECT DISTINCT(bd_id), bd_titre, bd_resume, bd_image, aut_nom "
                                . "FROM bandesdessinees "
                                . "INNER JOIN auteurs "
                                    . "ON bd_auteur_id = aut_id "
                                . "INNER JOIN liens_bd_themes "
                                    . "ON bd_id = lien_bd_id "
                                . "INNER JOIN themes "
                                    . "ON lien_themes_id = th_id "
                                . "WHERE LOWER(bd_titre) LIKE LOWER(:titre) "
                                    . "AND LOWER(aut_nom) LIKE LOWER(:auteur) "
                                    . "AND LOWER(th_intitule) LIKE LOWER(:theme) "
                                . "ORDER BY bd_titre asc "
                                . "LIMIT :limit,:nbBD";
            }
            // Si le thème n'est pas renseigné
            else {
                $sRequete = "SELECT DISTINCT(bd_id), bd_titre, bd_resume, bd_image, aut_nom "
                                . "FROM bandesdessinees "
                                . "INNER JOIN auteurs "
                                    . "ON bd_auteur_id = aut_id "
                                . "WHERE LOWER(bd_titre) LIKE LOWER(:titre) "
                                    . "AND LOWER(aut_nom) LIKE LOWER(:auteur) "
                                . "ORDER BY bd_titre asc "
                                . "LIMIT :limit,:nbBD";
            }
            
            // Préparation de la requête
            $sSelect = $sDB->prepare($sRequete);
            
            $sSelect->bindParam(':titre', $sTitre, PDO::PARAM_STR);
            $sSelect->bindParam(':auteur', $sAuteur, PDO::PARAM_STR);
            // Si le thème est renseigné, liaison de $sTheme au paramètre :theme
            if ($sTheme !== "%%") {
                $sSelect->bindParam(':theme', $sTheme, PDO::PARAM_STR);
            }
            $sSelect->bindParam(':limit', $sLimite, PDO::PARAM_INT);
            $sSelect->bindParam(':nbBD', $sNbBD, PDO::PARAM_INT);
            
            // Exécution de la requête => arrêt si erreur dans la requête SQL
            $sSelect->execute() or die("Erreur dans la requête SQL :".$sRequete);
            
            // Récupération de la sélection
            $tBDSelect = $sSelect->fetchAll(PDO::FETCH_OBJ);
            
            // Fermeture de la requête et déconnexion de la dB
            $sSelect->closeCursor();
            $sDB = null;
            
            // Si des BD ont été trouvées
            if ($tBDSelect) {
                // Création du tableau contenant les BD
                foreach ($tBDSelect as $sBDSelect) {
                    $tBD[] = new BandeDessinee($sBDSelect->bd_id,
                                             $sBDSelect->bd_titre,
                                             $sBDSelect->bd_resume,
                                             $sBDSelect->bd_image,
                                             $sBDSelect->aut_nom);
                }
            }
            // Sinon on retourne faux
            else {
                $tBD = false;
            }
            
            return $tBD;
        }        
    
    
        // Fonction :   getTotalBD
        // Desc :       Récupération du total des enregistrements dans la table bandesdessinees
        // IN :         RAS
        // OUT :        $sTotal (int) : Total d'enregistrements dans la table bandesdessinees
        public function getTotalBD() {
            // Ouverture de la connexion à la DB
            $sDB = connectDB();

            // Création de la requête SQL
            $sRequete = "SELECT count(*) as total "
                    . "FROM bandesdessinees ";

            // Exécution de la requête => arrêt si erreur dans la requête SQL
            $sRecupTotal = $sDB->query($sRequete) or die("Erreur dans la requête SQL :".$sRequete);

            // Récupération de la sélection dans la table bandesdessinees
            $sResultat = $sRecupTotal->fetch(PDO::FETCH_OBJ);
            
            // Fermeture de la requête et de la connexion
            $sRecupTotal->closeCursor();
            $sDB = null;
            
            // Récupération de la valeur
            $sTotal = $sResultat->total;

            return $sTotal;
        }
        
        // Fonction :   getTotBDSearch
        // Desc :       Permet de récupérer le nombre total de BD sélectionées
        //              selon les critères de recherche saisis par l'utilisateur
        // IN :         $sTitre (string) : Titre, complet ou en partie, saisi par l'utilisateur
        //              $sAuteur (string) : Nom de l'auteur sélectioné par l'utilisateur
        //              $sTheme (string) : Intitulé du thème sélectionné par l'utilisateur
        public function getTotBDSearch($sTitre, $sAuteur, $sTheme) {
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
             
            // Création de la requête
            // Si le thème est renseigné
            if ($sTheme !== "%%") {
                $sRequete = "SELECT COUNT(*) as total "
                                . "FROM bandesdessinees "
                                . "INNER JOIN auteurs "
                                    . "ON bd_auteur_id = aut_id "
                                . "INNER JOIN liens_bd_themes "
                                    . "ON bd_id = lien_bd_id "
                                . "INNER JOIN themes "
                                    . "ON lien_themes_id = th_id "
                                . "WHERE LOWER(bd_titre) LIKE LOWER(:titre) "
                                    . "AND LOWER(aut_nom) LIKE LOWER(:auteur) "
                                    . "AND LOWER(th_intitule) LIKE LOWER(:theme)";
            }
            // Si le thème n'est pas renseigné
            else {
                $sRequete = "SELECT COUNT(*) as total "
                                . "FROM bandesdessinees "
                                . "INNER JOIN auteurs "
                                    . "ON bd_auteur_id = aut_id "
                                . "WHERE LOWER(bd_titre) LIKE LOWER(:titre) "
                                    . "AND LOWER(aut_nom) LIKE LOWER(:auteur)";
            }
            
            // Préparation de la requête
            $sSelect = $sDB->prepare($sRequete);
            
            $sSelect->bindParam(':titre', $sTitre, PDO::PARAM_STR);
            $sSelect->bindParam(':auteur', $sAuteur, PDO::PARAM_STR);
            // Si le thème est renseigné, liaison de $sTheme au paramètre :theme
            if ($sTheme !== "%%") {
                $sSelect->bindParam(':theme', $sTheme, PDO::PARAM_STR);
            }
            
            // Exécution de la requête => arrêt si erreur dans la requête SQL
            $sSelect->execute() or die("Erreur dans la requête SQL :".$sRequete);
            
            // Récupération de la sélection
            $sResultat = $sSelect->fetch(PDO::FETCH_OBJ);
            
            // Fermeture de la requête et déconnexion de la dB
            $sSelect->closeCursor();
            $sDB = null;
            
            // Récupération de la valeur
            $sTotal = $sResultat->total;

            return $sTotal;
        }
        
        // Fonction :   getInfoBD
        // Desc :       Permet de récupérer les informations d'une BD grâce à son
        //              identifiant passé en paramètre
        // IN :         $sIdBD (int) : Identifiant de la BD
        // OUT :        $sBD (BandeDessinee) : Informations de la BD
        public function getInfoBD($sIdBD) {
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
                
            // Création de la requête
            $sRequete = "SELECT bd_id, bd_titre, bd_resume, bd_image, aut_nom "
                    . "FROM bandesdessinees "
                    . "INNER JOIN auteurs "
                    . "ON bd_auteur_id = aut_id "
                    . "WHERE bd_id = :idBD";
            
            // Préparation de la requête
            $sSelect = $sDB->prepare($sRequete);
            
            $sSelect->bindParam(':idBD', $sIdBD, PDO::PARAM_INT);
            
            // Exécution de la requête => arrêt si erreur dans la requête SQL
            $sSelect->execute() or die("Erreur dans la requête SQL :".$sRequete);
            
            // Récupération de la sélection
            $sBDSelect = $sSelect->fetch(PDO::FETCH_OBJ);
            
            // Fermeture de la requête et déconnexion de la dB
            $sSelect->closeCursor();
            $sDB = null;
            
            // Création de la BD rechercher
            $sBD = new BandeDessinee($sBDSelect->bd_id,
                                     $sBDSelect->bd_titre,
                                     $sBDSelect->bd_resume,
                                     $sBDSelect->bd_image,
                                     $sBDSelect->aut_nom);
            
            return $sBD;
        }
        
        // Fonction :   ajoutBD
        // Desc :       Permet d'ajouter une BD à la DB
        // IN :         $sNouvelleBD (BandeDessinee) : BD à insérer à la DB
        // OUT :        $sInsertOK (boolean) : Si l'insert est effectué, retourne true
        //                                     sinon, rtourne false
        public function ajoutBD($sNouvelleBD) {
            // Récupration des données saisies
            $sTitre = $sNouvelleBD->getTitre();
            $sResume = $sNouvelleBD->getResume();
            $sImage = $sNouvelleBD->getImage();
            $sIdAuteur = intval($sNouvelleBD->getAuteur());
            
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
                
            // Création de la requête
            $sRequete = "INSERT INTO bandesdessinees (bd_titre, bd_resume, bd_image, bd_auteur_id) "
                    . "VALUES (:titre, :resume, :image, :idAut)";
            
            // Préparation de la requête
            $sInsert = $sDB->prepare($sRequete);
            
            $sInsert->bindParam(':titre', $sTitre, PDO::PARAM_STR);
            $sInsert->bindParam(':resume', $sResume, PDO::PARAM_STR);
            $sInsert->bindParam(':image', $sImage, PDO::PARAM_STR);
            $sInsert->bindParam(':idAut', $sIdAuteur, PDO::PARAM_INT);
            
            // Exécution de la requête => arrêt si erreur dans la requête SQL
            $sInsertOK = $sInsert->execute() or die("Erreur dans la requête SQL :".$sRequete);
                 
            // Fermeture de la requête et déconnexion de la dB
            $sInsert->closeCursor();
            $sDB = null;
            
            return $sInsertOK;
        }
    }
?>