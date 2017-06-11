            <div id="pos_accueil_admin">
                <fieldset>
                    <legend>En attente</legend>
                    <p>Bonjour <?php print $_SESSION['id']; ?>!</p>
                    <p>Vous avez <?php print sizeof($tComAValider)/2; ?> commentaires à vérifier</p>
                </fieldset>
            </div>