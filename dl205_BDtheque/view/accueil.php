                <fieldset id="consult_libre">
                    <legend>Consultation libre</legend>
                    <button type="button" id="valid_list_BD"
                            onclick="javascript: location.assign('index.php?choix=liste_BD');">
                        <?php print $sTextBtnConsult; ?>
                    </button>
                </fieldset>
                
                <fieldset id="connexion">
                    <legend>Connexion</legend>
                    <?php
                        // S'il n'y a aucune connexion effective en tant qu'administrateur
                        // => Formulaire de connexion
                        if (!isset($_SESSION['id'])) {
                    ?>
                    <form method="post" action="index.php?choix=verif_co_admin">
                        <label for="saisie_id">Identifiant :</label><br />
                        <input type="text" name="saisie_id" /><br />
                        
                        <label for="saisie_mdp">Mot de passe :</label><br />
                        <input type="password" name="saisie_mdp" /><br />
                        
                        <input type="submit" class="btn_formulaire" value="Valider" />
                    </form>
                    <?php
                        }
                        // Sinon => bouton de lien avec l'accueil administrateur
                        else {
                    ?>
                    <button type="button" id="valid_list_BD"
                            onclick="javascript: location.assign('index.php?choix=accueil_admin');">
                        Accueil administrateur
                    </button>
                    <?php
                        }
                    ?>
                </fieldset>
                    <?php
                        // S'il y a eu renvoi sur la page d'accueil après validation
                        // => Vérification du $_GET
                        if (isset($_GET['refus_co'])) {
                    ?>
                    <script>alert("Identifiant ou mot de passe invalide!");</script>
                    <?php
                        }
                    ?>