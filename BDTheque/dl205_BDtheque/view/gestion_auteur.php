                    <div class="pos_gestion">
                        <fieldset>
                            <legend>Gestion des auteurs</legend>
                            <form method="post" action="index.php?choix=verif_gest_aut">
                                <select name="gestion_auteur">
                                    <option value="" selected="selected">Nouvel auteur</option>
                                    <?php
                                        foreach ($tAuteur as $sAuteur) {
                                    ?>
                                    <option value="<?php print $sAuteur->getId(); ?>"><?php print $sAuteur->getNom(); ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                <input type="text" name="nouveau_nom" required="required" placeholder="nom de l'auteur" />
                                <br/><br/>
                                <input type="submit" name="ajouter" class="btn_formulaire" value="Ajouter" />
                                <input type="submit" name="modifier" class="btn_formulaire" value="Modifier" />
                            </form>
                        </fieldset>
                    </div>
                    <?php
                        if (isset($_GET['insert'])) {
                            if ($_GET['insert'] == 1) {
                    ?>
                    <script>alert("L'auteur a bien été ajouté.");</script>
                    <?php
                            }
                            else if ($_GET['insert'] === "existant") {
                    ?>
                    <script>alert("L'auteur existe déjà dans la base de données.");</script>
                    <?php
                            }
                            else {
                    ?>
                    <script>alert("L'auteur n'a pas pu être ajouté.");</script>
                    <?php
                            }
                        }
                        else if (isset($_GET['update'])) {
                            if ($_GET['update'] == 1) {
                    ?>
                    <script>alert("L'auteur a bien été modifié.");</script>
                    <?php                                
                            }
                            else {
                    ?>
                    <script>alert("L'auteur n'a pas pu être modifié.");</script>
                    <?php
                            }
                        }
                    ?>