<?php
    // Fonction :   creaMiniBD
    // Desc :       Permet de créer une miniature d'une image et de l'insérer dans un
    //              dossier
    // IN :         $NomImage (string) : Nom du fichier de l'image avec son extension
    // OUT :        RAS
    function creaMiniBD($NomImage) {
        //calcul des dimensions de la miniature à partir de celles de l’image d’origine
        list($width, $height) = getimagesize("img/couvBD/".$NomImage);
        $new_height = 150;
        $new_width = ($width/$height)*$new_height;

        //creation d’une image miniature en mémoire vers $image_mini_tmp
        $image_mini_tmp = imagecreatetruecolor($new_width, $new_height);

        //copie de l\'image à duppliquer en mémoire vers $image_tmp
        $image_tmp= imagecreatefromjpeg("img/couvBD/".$NomImage);

        // copie du contenu de $image_tmp, vers $image_mini_tmp en appliquant les nouvelles dimensions
        imagecopyresampled($image_mini_tmp, $image_tmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        //enregistrement de la miniature de crée vers $copieMini ;
        imagejpeg($image_mini_tmp , "img/miniBD/".$NomImage);
    }
?>