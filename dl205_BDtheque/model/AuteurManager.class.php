<?php
    // Import de la bibliothèque de connexion à la DB
    include_once 'model/db.inc.php';
    
    // Import de la classe Auteur
    include_once 'model/Auteur.class.php';
    
    class AuteurManager {
        // Fonction :   getListAuteur
        // Desc :       Permet d'obtenir la liste de tous les auteurs contenus dans la DB
        // IN :         RAS
        // OUT :        $tAuteur (Auteur) : Tableau contenant les auteurs de BD de la DB
        public function getListAuteur() {
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
            
            // Création de la requête
            $sRequete = "SELECT * "
                    . "FROM auteurs";
            
            // Envoi de la requête
            $sSelect = $sDB->query($sRequete) or die("Erreur dans la requête SQL : ".$sRequete);
            
            // Récupération du résultat de la sélection
            $tAuteurSelect = $sSelect->fetchAll(PDO::FETCH_OBJ);
            
            // Fermeture de la requête et de la connexion
            $sSelect->closeCursor();
            $sDB = null;
            
            // Récupération des thèmes dans un tableau
            foreach ($tAuteurSelect as $sAuteurSelect) {
                $tAuteur[] = new Auteur($sAuteurSelect->aut_id,
                                        $sAuteurSelect->aut_nom);
            }
            
            return $tAuteur;
        }
        
        // Fonction :   ajouterAuteur
        // Desc :       Permet d'ajouter un auteur à la table auteurs
        // IN :         $sAuteur (Auteur) : Auteur contenant le nom du nouvel auteur
        // OUT :        $sInsertOK (boolean) : si l'insert s'est effectué correctement, retourne true
        //                                     sinon, retourne false
        public function ajouterAuteur($sAuteur) {
            // Récupération du nom à ajouter
            $sNom = $sAuteur->getNom();
            
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
            
            // Création de la requête
            $sRequete = "INSERT INTO auteurs (aut_nom)"
                    . "VALUES (:nom)";
            
            // Préparation de la requête
            $sInsert = $sDB->prepare($sRequete);
            
            // Attribution de la valeur au paramètre
            $sInsert->bindParam(':nom', $sNom, PDO::PARAM_STR);
            
            // Récupération du résultat de l'insert
            $sInsertOK = $sInsert->execute() or die("Erreur dans la requête SQL : ".$sRequete);
            
            // Fermeture de la requête et de la connexion
            $sInsert->closeCursor();
            $sDB = null;
            
            return $sInsertOK;
        }
        
        // Fonction :   modifierAuteur
        // Desc :       Permet de modifier le nom d'un auteur de la table auteurs
        // IN :         $sAuteur (Auteur) : Auteur contenant l'identifiant d'un auteur
        //                                  de la DB et le nouveau nom à modifier
        // OUT :        $sUpdateOK (boolean) : si l'update s'est effectué correctement, retourne true
        //                                     sinon, retourne false
        public function modifierAuteur($sAuteur) {
            // Récupération de l'identifiant et du nom à modifier
            $sId = $sAuteur->getId();
            $sNom = $sAuteur->getNom();
            
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
            
            // Création de la requête
            $sRequete = "UPDATE auteurs "
                    . "SET aut_nom = :nom "
                    . "WHERE aut_id = :id";
            
            // Préparation de la requête
            $sUpdate = $sDB->prepare($sRequete);
            
            // Attribution de la valeur au paramètre
            $sUpdate->bindParam(':id', $sId, PDO::PARAM_INT);
            $sUpdate->bindParam(':nom', $sNom, PDO::PARAM_STR);
            
            // Récupération du résultat de l'insert
            $sUpdateOK = $sUpdate->execute() or die("Erreur dans la requête SQL : ".$sRequete);
            
            // Fermeture de la requête et de la connexion
            $sUpdate->closeCursor();
            $sDB = null;
            
            return $sUpdateOK;
        }
        
        // Fonction :   verifAuteur
        // Desc :       Permet de vérifier si l'auteur existe déjà dans la DB
        // IN :         $sAuteur (Auteur) : Auteur à rechercher dans la DB
        // OUT :        $sAuteurOK (boolean) : Si l'auteur est trouvé dans la DB, retourne true
        //                                     sinon retourne, false
        public function verifAuteur($sAuteur) {
            // Récupération de l'identifiant et du nom à modifier
            $sNom = $sAuteur->getNom();
            
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
            
            // Création de la requête
            $sRequete = "SELECT COUNT(*) "
                    . "FROM auteurs "
                    . "WHERE LOWER(aut_nom) = LOWER(:nom)";
            
            // Préparation de la requête
            $sSelect = $sDB->prepare($sRequete);
            
            // Attribution de la valeur au paramètre
            $sSelect->bindParam(':nom', $sNom, PDO::PARAM_STR);
            
            // Récupération du résultat de l'insert
            $sSelect->execute() or die("Erreur dans la requête SQL : ".$sRequete);
            
            // Récupération de la sélection
            $sAuteurSelect = $sSelect->fetch(PDO::FETCH_OBJ);
            
            // Si l'auteur existe
            if ($sAuteurSelect) {
                $sAuteurOK = true;
            }
            else {
                $sAuteurOK = false;
            }
            
            // Fermeture de la requête et de la connexion
            $sSelect->closeCursor();
            $sDB = null;
            
            return $sAuteurOK;
        }
    }
?>