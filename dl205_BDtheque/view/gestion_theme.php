                    <div class="pos_gestion">
                        <fieldset>
                            <legend>Gestion des thèmes</legend>
                            <form method="post" action="index.php?choix=verif_gest_theme">
                                <select name="gestion_theme">
                                    <option value="">Nouveau thème</option>
                                    <?php
                                        foreach ($tTheme as $sTheme) {
                                    ?>
                                    <option value="<?php print $sTheme->getId(); ?>"><?php print $sTheme->getIntitule(); ?></option>
                                    <?php
                                        }
                                    ?>
                                    <input type="text" name="nouvel_intitule" required="required" placeholder="intitulé du thème" />
                                    <br/><br/>
                                    <input type="submit" class="btn_formulaire" name="ajouter" value="Ajouter" />
                                    <input type="submit" class="btn_formulaire" name="modifier" value="Modifier" />
                                </select>
                            </form>
                        </fieldset>
                    </div>
                    <?php
                        if (isset($_GET['insert'])) {
                            if ($_GET['insert'] == 1) {
                    ?>
                    <script>alert("Le thème a bien été ajouté.");</script>
                    <?php
                            }
                            else if ($_GET['insert'] === "existant") {
                    ?>
                    <script>alert("Le thème existe déjà dans la base de données.");</script>
                    <?php
                            }
                            else {
                    ?>
                    <script>alert("Le thème n'a pas pu être ajouté.");</script>
                    <?php
                            }
                        }
                        else if (isset($_GET['update'])) {
                            if ($_GET['update'] == 1) {
                    ?>
                    <script>alert("Le thème a bien été modifié.");</script>
                    <?php                                
                            }
                            else {
                    ?>
                    <script>alert("Le thème n'a pas pu être modifié.");</script>
                    <?php
                            }
                        }
                    ?>