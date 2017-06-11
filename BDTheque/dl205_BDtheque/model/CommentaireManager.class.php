<?php
    // Import de la bibliothèque de connexion à la DB
    include_once 'model/db.inc.php';
    
    // Import de la classe Commentaire
    include_once 'model/Commentaire.class.php';
    
    class CommentaireManager {
        // Fonction :   getComBD
        // Desc :       Permet de récupérer, dans la DB, les commentaires liés à une BD
        //              et qui ont été validés par l'administrateur
        // IN :         $sID (int) : Identifiant de la BD
        // OUT :        $tComBD (Commentaire) : Tableau de commentaires validés liés à la BD
        public function getComBD($sIdBD) {
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
             
            // Création de la requête
            $sRequete = "SELECT * "
                    . "FROM commentaires "
                    . "INNER JOIN bandesdessinees "
                    . "ON com_bd_id = bd_id "
                    . "WHERE bd_id = :idBD "
                    . "AND com_mod = 1 "
                    . "ORDER BY com_date";
            
            // Préparation de la requête
            $sSelect = $sDB->prepare($sRequete);
            
            $sSelect->bindParam(':idBD', $sIdBD, PDO::PARAM_INT);
            
            // Exécution de la requête => arrêt si erreur dans la requête SQL
            $sSelect->execute() or die("Erreur dans la requête SQL :".$sRequete);
            
            // Récupération de la sélection
            $tComSelect = $sSelect->fetchAll(PDO::FETCH_OBJ);
            
            // Fermeture de la requête et déconnexion de la dB
            $sSelect->closeCursor();
            $sDB = null;
            
            // Si des commentaires ont été trouvés
            if ($tComSelect) {
                // Création du tableau des commentaires sur la BD
                foreach ($tComSelect as $sComSelect) {
                    $tComBD[] = new Commentaire($sComSelect->com_id,
                                                $sComSelect->com_bd_id,
                                                $sComSelect->com_date,
                                                $sComSelect->com_auteur,
                                                $sComSelect->com_texte);
                }
            }
            // Sinon, on renvoit faux
            else {
                $tComBD = false;
            }
            
            return $tComBD;
        }
        
        // Fonction :   getComAValider
        // Desc :       Permet de récupérer la liste des commentaires à valider
        // IN :         RAS
        // OUT :        $tComBDAValider (Commentaire) : tableau des commentaires
        //                                              en attente de modération
        public function getComAValider() {
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
             
            // Création de la requête
            $sRequete = "SELECT bd_titre, com_id, com_bd_id, com_date, com_auteur, com_texte "
                    . "FROM commentaires "
                    . "INNER JOIN bandesdessinees "
                    . "ON com_bd_id = bd_id "
                    . "WHERE com_mod = 0 "
                    . "ORDER BY bd_titre";
            
            // Préparation de la requête
            $sSelect = $sDB->query($sRequete) or die("Erreur dans la requête SQL :".$sRequete);
            
            // Récupération des résultats
            $tResultat = $sSelect->fetchAll(PDO::FETCH_OBJ);
            
            // Fermeture de la requête et déconnexion de la dB
            $sSelect->closeCursor();
            $sDB = null;
            
            // Si des commentaires ont été trouvés
            if ($tResultat) {
                // Création du tableau des commentaires sur la BD
                foreach ($tResultat as $sComSelect) {
                    $tComBDAValider[] = new Commentaire($sComSelect->com_id,
                                                $sComSelect->com_bd_id,
                                                $sComSelect->com_date,
                                                $sComSelect->com_auteur,
                                                $sComSelect->com_texte);
                    $tComBDAValider[] = $sComSelect->bd_titre;
                }
            }
            // Sinon, on renvoit faux
            else {
                $tComBDAValider = false;
            }
            
            return $tComBDAValider;
        }
        
        // Fonction :   insertCom
        // Desc :       Permet d'ajouter un nouveau commentaire dans la table commentaires
        //              de la DB cataloguebd avec pour statut de modération com_mod = 0
        // IN :         $sNouveauCom (Commentaire) : Commentaire saisi par un utilisateur
        // OUT :        $sInsertOK (boolean) : Si l'insert s'est effectué correctement, retourne true
        //                                     sinon, retourne false
        public function insertCom($sNouveauCom) {
            // Récupération des valeurs des données du commentaires
            $sIdBd = intval($sNouveauCom->getBD());
            $sAuteur = $sNouveauCom->getAuteur();
            $sTexte = $sNouveauCom->getTexte();
            $sMod = $sNouveauCom->getModeration();
            
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
             
            // Création de la requête
            $sRequete = "INSERT INTO commentaires (com_bd_id, com_auteur, com_texte, com_mod) "
                    . "VALUES (:idBd,:auteur,:texte,:mod)";
            
            // Préparation de la requête
            $sInsert = $sDB->prepare($sRequete);
            
            // Affectation des variables aux paramètres
            $sInsert->bindParam(':idBd', $sIdBd, PDO::PARAM_INT);
            $sInsert->bindParam(':auteur', $sAuteur, PDO::PARAM_STR);
            $sInsert->bindParam(':texte', $sTexte, PDO::PARAM_STR);
            $sInsert->bindParam(':mod', $sMod, PDO::PARAM_INT);
            
            // Exécution de la requête
            $sInsertOK = $sInsert->execute() or die("Erreur dans la requête SQL :".$sRequete);
            
            // Fermeture de la requête et déconnexion de la dB
            $sInsert->closeCursor();
            $sDB = null;
            
            return $sInsertOK;
        }
        
        // Fonction :   validerCom
        // Desc :       Permet de modifier la modération du commentaire de soumis(com_mod = 0)
        //              à accepté (com_mod = 1)
        // IN :         $sIdCom (int) : Identifiant du commentaire à valider
        // OUT :        $sUpdateOK (boolean) : si l'update s'est effectué correctement, retourne true
        //                                     sinon, retourne false
        public function validerCom($sIdCom) {
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
             
            // Création de la requête
            $sRequete = "UPDATE commentaires "
                    . "SET com_mod = 1 "
                    . "WHERE com_id = :idCom";
            
            // Préparation de la requête
            $sUpdate = $sDB->prepare($sRequete);
            
            // Affectation des variables aux paramètres
            $sUpdate->bindParam(':idCom', $sIdCom, PDO::PARAM_INT);
                        
            // Exécution de la requête
            $sUpdateOK = $sUpdate->execute() or die("Erreur dans la requête SQL :".$sRequete);
            
            // Fermeture de la requête et déconnexion de la dB
            $sUpdate->closeCursor();
            $sDB = null;
            
            return $sUpdateOK;
        }
        
        // Fonction :   supprimerCom
        // Desc :       Permet de supprimer un commentaire
        // IN :         $sIdCom (int) : Identifiant du commentaire à supprimer
        // OUT :        $sDeletetOK (boolean) : si la suppression s'est effectuée correctement, retourne true
        //                                      sinon, retourne false
        public function supprimerCom($sIdCom) {
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
             
            // Création de la requête
            $sRequete = "DELETE FROM commentaires "
                    . "WHERE com_id = :idCom";
            
            // Préparation de la requête
            $sDelete = $sDB->prepare($sRequete);
            
            // Affectation des variables aux paramètres
            $sDelete->bindParam(':idCom', $sIdCom, PDO::PARAM_INT);
                        
            // Exécution de la requête
            $sDeleteOK = $sDelete->execute() or die("Erreur dans la requête SQL :".$sRequete);
            
            // Fermeture de la requête et déconnexion de la dB
            $sDelete->closeCursor();
            $sDB = null;
            
            return $sDeleteOK;
        }
        
        // Fonction :   modifierCom
        // Desc :       Permet de modifier le texte d'un commentaire soumis et de le valider
        // IN :         $sIdCom (int) : Identifiant du commentaire à modifier
        // OUT :        $sUpdtaeOK (boolean) : si l'update s'est effectué correctement, retourne true
        //                                     sinon, retourne false
        public function modifierCom($sIdCom,$sTexte) {
            // Récupération de la date
            $sDate = date("Y-m-d H:i:s");
            
            // Ajout d'un message pour indiquer que le message a été modifié
            $sTexte .= "<br/><br/>modifié par admin le : ".$sDate;
                    
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
             
            // Création de la requête
            $sRequete = "UPDATE commentaires "
                    . "SET com_mod = 1, com_texte = :texte "
                    . "WHERE com_id = :idCom";
            
            // Préparation de la requête
            $sUpdate = $sDB->prepare($sRequete);
            
            // Affectation des variables aux paramètres
            $sUpdate->bindParam(':idCom', $sIdCom, PDO::PARAM_INT);
            $sUpdate->bindParam(':texte', $sTexte, PDO::PARAM_STR);
                        
            // Exécution de la requête
            $sUpdateOK = $sUpdate->execute() or die("Erreur dans la requête SQL :".$sRequete);
            
            // Fermeture de la requête et déconnexion de la dB
            $sUpdate->closeCursor();
            $sDB = null;
            
            return $sUpdateOK;
        }
    }
?>