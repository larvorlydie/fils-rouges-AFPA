<?php
    // Import de la bibliothèque de connexion
    include_once 'model/db.inc.php';
    
    // Import de la classe Compte
    include_once 'model/Compte.class.php';


    class CompteManager {
        // Fonction :   verifCompte
        // Desc :       Permet de vérifier l'existence d'un compte dans la DB
        //              par rapport à l'identifiant et le mot de passe saisi par
        //              l'utilisateur
        // IN :         $sCompteSaisi : compte à vérifier
        // OUT :        boolean : true si le compte a été trouvé, sinon false
        public function verifCompte($sCompteSaisi) {
            // Récupération des données du compte saisi
            $sId = $sCompteSaisi->getId();
            $sMdp = $sCompteSaisi->getMdp();

            // Ouverture de la connexion à la DB
            $sDB = connectDB();

            // Création de la requête SQL
            $sRequete = "SELECT * FROM compte WHERE compte_id = :id AND compte_mdp = :mdp";

            // Préparation de la requête
            $sVerif = $sDB->prepare($sRequete);

            // Affectation des paramètres
            $sVerif->bindParam(':id', $sId, PDO::PARAM_STR);
            $sVerif->bindParam(':mdp', $sMdp, PDO::PARAM_STR);

            // Exécution de la requête ou message d'erreur
            $sVerif->execute() or die("Erreur dans la requête SQL :".$sRequete);

            // Récupération du résultat de la requête
            $sCompteTrouve = $sVerif->fetch(PDO::FETCH_OBJ);

            // Fermeture de la requête et de la connexion
            $sVerif->closeCursor();
            $sDB = null;

            // Valeur retournée par la fonction
            if ($sCompteTrouve) return true;
            else return false;
        }
    }
?>