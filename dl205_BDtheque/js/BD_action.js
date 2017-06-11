// Fonction :   afficheMenuRecherche
// Desc :       Permet d'afficher ou de cacher le menu identifié
// IN :         idElement (string) : Identifiant de l'élément concerné
// OUT :        RAS
function afficheMenu(idElement) {
    // Si le menu de recherche est affiché => cache-le
    if (document.getElementById(idElement).style.display == "block") {
        document.getElementById(idElement).style.display = "none";
    }
    // Sinon affiche-le
    else {
        document.getElementById(idElement).style.display = "block";
    }
}