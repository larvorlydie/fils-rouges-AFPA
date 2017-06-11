<?php
    // Fonction :   connectDB
    // Desc :       Permet d'établir la connexion à la base de données
    // IN :         RAS
    // OUT :        $sDB : Variable contenant l'identifiant de connexion
    function connectDB() {
        // Récupération des paramètres de connexion à la base de données
        require("ini/db.conf.php");
        
        try {
            // Ouverture de la connexion à la BD
            $sDB = new PDO("mysql:host=".$sHost.";charset=utf8;dbname=".$sBase,
            $sLogin, $sPassword);

            return $sDB;
        } 
        catch (Exception $e) {
            print 'Erreur : ' . $e->getMessage() . '<br />';
            print 'N° : ' . $e->getCode();
            die("Connexion au serveur impossible. <br />"
                    . "<a href=\"javascript:history.go(-1) \">Retour</a>");
        }
    }
?>