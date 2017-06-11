<?php
    function getFilAriane($sLimite,$sNbBD,$sChoix) {
        // Import du manager de BandeDessinee
        include_once 'model/BandeDessineeManager.class.php';
        
        // Lancement du manager
        $sManBD = new BandeDessineeManager(); 
        
        // Détermination des limites pour les boutons de navigation
        $sLimitePrec = $sLimite - $sNbBD;
        $sLimiteSuiv = $sLimite + $sNbBD;
        
        // Récupération du nombre total de BD dans la table bandesdessinees
        if (isset($_SESSION['recherche_titre'])) {
            // Récupération des valeurs des saisies
            $sTitre = $_SESSION['recherche_titre'];
            $sAuteur = $_SESSION['recherche_auteur'];
            $sTheme = $_SESSION['recherche_theme'];
            
            $sTotal = $sManBD->getTotBDSearch($sTitre, $sAuteur, $sTheme);
        }
        else {
            $sTotal = $sManBD->getTotalBD();
        }
        
        // Fermeture du manager
        $sManBD = null;
        
        // Détermination du nombre max de pages à afficher dans le fil d'ariane
        $sNbPage = floor($sTotal / $sNbBD);
        
        // Initialisation de la variable qui va permettant de naviguer entre les pages
        $sFilAriane = "";

        // Menu de navigation entre les pages
        // Bouton précédent => apparait seulement si ce n'est pas la première page
        if ($sLimite !== 0) {
            print "\n\t\t\t"."<!-- Bouton Précédent -->"."\n\t\t\t";
            print "<button type='button' class='btn_ariane' "."\n\t\t\t\t"
                    . "onclick='javascript: location.assign(\"index.php?choix=".$sChoix."&limite=".$sLimitePrec."\");'>"."\n\t\t\t\t"
                    . "Précédent"."\n\t\t\t"
                    . "</button>"."\n\n\t\t\t";
        }
        // Création du menu de navigation entre les pages
        for ($i = 0; $i <= $sNbPage; $i++) {
            if ($i == $sNbPage) {
                $sFilAriane .= "<a href='index.php?choix=".$sChoix."&limite=".($i*$sNbBD)."'>".($i+1)."</a>"."\n";
                continue;
            }
            $sFilAriane .= "<a href='index.php?choix=".$sChoix."&limite=".($i*$sNbBD)."'>".($i+1)."</a> -"."\n\t\t\t";                   
        }
        // Insertion du menu
        print "<!-- Numéros de page pour la navigation -->"."\n\t\t\t";
        print $sFilAriane;

        // Bouton suivant => apparait seulement si ce n'est pas la dernière page
        if ($sLimiteSuiv < $sTotal) {
            print "\n\t\t\t"."<!-- Bouton Suivant -->"."\n\t\t\t";
            print "<button type='button' class='btn_ariane' "."\n\t\t\t\t"
                    . "onclick='javascript: location.assign(\"index.php?choix=".$sChoix."&limite=".$sLimiteSuiv."\");'>"."\n\t\t\t\t"
                    . "Suivant"."\n\t\t\t"
                    . "</button>"."\n\t\t";
        }
    }
?>