<?php
    // Import de la bibliothèque de connexion à la DB
    include_once 'model/db.inc.php';
    
    // Import de la classe Theme
    include_once 'model/Theme.class.php';
    
    class ThemeManager {
        // Fonction :   getThemeBD
        // Desc :       Récupération des thèmes dans la table themes
        // IN :         $sIdBD (int) : Identifiant de la BD
        // OUT :        $sTheme (string) : Chaine de caractères contenant tous
        //                                 les thèmes liés à la BD
        public function getThemeBD($sIdBD){
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
            
            // Création de la requête
            $sRequete = "SELECT th_intitule "
                    . "FROM themes t "
                    . "INNER JOIN liens_bd_themes l "
                    . "ON th_id = lien_themes_id "
                    . "WHERE lien_bd_id = :idBD";
            
            // Préparation de la requête
            $sSelect = $sDB->prepare($sRequete);
            
            $sSelect->bindParam(':idBD', $sIdBD, PDO::PARAM_INT);
            
            $sSelect->execute() or die("Erreur dans la requête SQL : ".$sRequete);
            
            // Récupération du résultat de la sélection
            $tThemeSelect = $sSelect->fetchAll(PDO::FETCH_OBJ);
            
            // Fermeture de la requête et de la connexion
            $sSelect->closeCursor();
            $sDB = null;
            
            // récupération des thèmes de la BD sous forme d'une chaîne de caractères
            $sTheme = "";
            for ($i = 0; $i < sizeof($tThemeSelect); $i++) {
                if ($i === (sizeof($tThemeSelect)-1)){
                    $sTheme .= $tThemeSelect[$i]->th_intitule;
                }
                else {
                    $sTheme .= $tThemeSelect[$i]->th_intitule.", ";
                }
            }
            
            return $sTheme;
        }
        
        // Fonction :   getListTheme
        // Desc :       Permet d'obtenir la liste de tous les thèmes contenus dans la DB
        // IN :         RAS
        // OUT :        $tTheme (Theme) : Tableau contenant tous les thèmes de la DB
        public function getListTheme() {
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
            
            // Création de la requête
            $sRequete = "SELECT * "
                    . "FROM themes";
            
            // Envoi de la requête
            $sSelect = $sDB->query($sRequete) or die("Erreur dans la requête SQL : ".$sRequete);
            
            // Récupération du résultat de la sélection
            $tThemeSelect = $sSelect->fetchAll(PDO::FETCH_OBJ);
            
            // Fermeture de la requête et de la connexion
            $sSelect->closeCursor();
            $sDB = null;
            
            // Récupération des thèmes dans un tableau
            foreach ($tThemeSelect as $sThemeSelect) {
                $tTheme[] = new Theme($sThemeSelect->th_id,
                                      $sThemeSelect->th_intitule);
            }
            
            return $tTheme;
        }
        
        // Fonction :   ajouterTheme
        // Desc :       Permet d'ajouter un thème à la table themes
        // IN :         $sTheme (Theme) : Theme contenant l'intitulé du nouveau thème
        // OUT :        $sInsertOK (boolean) : si l'insert s'est effectué correctement, retourne true
        //                                     sinon, retourne false
        public function ajouterTheme($sTheme) {
            var_dump($sTheme);
            // Récupération du nom à ajouter
            $sIntitule = $sTheme->getIntitule();
            
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
            
            // Création de la requête
            $sRequete = "INSERT INTO themes (th_intitule) "
                    . "VALUES (:intitule)";
            
            // Préparation de la requête
            $sInsert = $sDB->prepare($sRequete);
            
            // Attribution de la valeur au paramètre
            $sInsert->bindParam(':intitule', $sIntitule, PDO::PARAM_STR);
            
            // Récupération du résultat de l'insert
            $sInsertOK = $sInsert->execute() or die("Erreur dans la requête SQL : ".$sRequete);
            
            // Fermeture de la requête et de la connexion
            $sInsert->closeCursor();
            $sDB = null;
            
            return $sInsertOK;
        }
        
        // Fonction :   modifierTheme
        // Desc :       Permet de modifier l'intitulé d'un thème de la table themes
        // IN :         $sTheme (Theme) : Theme contenant l'identifiant d'un thème
        //                                de la DB et le nouvel intitulé à modifier
        // OUT :        $sUpdateOK (boolean) : si l'update s'est effectué correctement, retourne true
        //                                     sinon, retourne false
        public function modifierTheme($sTheme) {
            // Récupération de l'identifiant et du nom à modifier
            $sId = $sTheme->getId();
            $sIntitule = $sTheme->getIntitule();
            
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
            
            // Création de la requête
            $sRequete = "UPDATE themes "
                    . "SET th_intitule = :intitule "
                    . "WHERE th_id = :id";
            
            // Préparation de la requête
            $sUpdate = $sDB->prepare($sRequete);
            
            // Attribution de la valeur au paramètre
            $sUpdate->bindParam(':id', $sId, PDO::PARAM_INT);
            $sUpdate->bindParam(':intitule', $sIntitule, PDO::PARAM_STR);
            
            // Récupération du résultat de l'insert
            $sUpdateOK = $sUpdate->execute() or die("Erreur dans la requête SQL : ".$sRequete);
            
            // Fermeture de la requête et de la connexion
            $sUpdate->closeCursor();
            $sDB = null;
            
            return $sUpdateOK;
        }
        
        // Fonction :   verifTheme
        // Desc :       Permet de vérifier si le thème existe déjà dans la DB
        // IN :         $sTheme (Theme) : Thème à rechercher dans la DB
        // OUT :        $sThemeOK (boolean) : Si le thème est trouvé dans la DB, retourne true
        //                                     sinon retourne, false
        public function verifTHeme($sTheme) {
            // Récupération de l'identifiant et du nom à modifier
            $sIntitule = $sTheme->getIntitule();
            
            // Ouverture de la connexion à la DB
            $sDB = connectDB();
            
            // Création de la requête
            $sRequete = "SELECT COUNT(*) "
                    . "FROM themes "
                    . "WHERE LOWER(th_intitule) = LOWER(:intitule)";
            
            // Préparation de la requête
            $sSelect = $sDB->prepare($sRequete);
            
            // Attribution de la valeur au paramètre
            $sSelect->bindParam(':intitule', $sIntitule, PDO::PARAM_STR);
            
            // Récupération du résultat de l'insert
            $sSelect->execute() or die("Erreur dans la requête SQL : ".$sRequete);
            
            // Récupération de la sélection
            $sThemeSelect = $sSelect->fetch(PDO::FETCH_OBJ);
            
            // Si le thème existe
            if ($sThemeSelect) {
                $sThemeOK = true;
            }
            else {
                $sThemeOK = false;
            }
            
            // Fermeture de la requête et de la connexion
            $sSelect->closeCursor();
            $sDB = null;
            
            return $sThemeOK;
        }
    }
?>