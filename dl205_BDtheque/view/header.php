<!DOCTYPE html>
<html>
    <head>
        <title><?php print $sTitreOnglet; ?></title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <link type="text/css" rel="stylesheet" href="css/BD_style.css" />
        
        <script type="text/javascript" language="javascript"
                src="js/BD_action.js"></script>
    </head>
    
    <body>
        <div id="pos_page">
            <header>
                <h1>
                    <?php 
                        if (!isset($_GET['choix']) or $_GET['choix'] === "accueil") {
                            print "Bienvenue à ".$sTitreHeader;
                        }
                        else {
                            print $sTitreHeader;
                        }
                    ?>
                </h1>
            </header>
            
            <section id="corps_page">
            <?php print "\n"; ?>