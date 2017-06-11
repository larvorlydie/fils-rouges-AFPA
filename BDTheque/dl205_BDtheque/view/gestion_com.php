                    <div class="pos_gestion">
                        <fieldset>
                            <legend>Commentaires à modérer</legend>
                            <?php
                                // S'il y a des commentaires validés à afficher
                                if ($tComAValider) {
                                    for ($i = 0; $i < sizeof($tComAValider); $i += 2) {
                            ?>
                            <!-- Commentaire à modérer n°<?php print $i+1; ?> -->
                            <article class="com_gestion" id="com_<?php print $i+1; ?>">
                                <form method="post" action="index.php?choix=mod_com">
                                    <h1 class="titre_BD">Titre de la BD : <?php print $tComAValider[$i+1]; ?></h1>
                                    <h2>Auteur du commentaire : <?php print $tComAValider[$i]->getAuteur(); ?></h2>
                                    <h2 class="date_gestion_com">le : <?php print $tComAValider[$i]->getdate(); ?></h2>
                                    <textarea name="texte_com_modere" required="required"><?php print $tComAValider[$i]->getTexte(); ?></textarea>
                                
                                    <input type="hidden" name="id_com_modere" value="<?php print $tComAValider[$i]->getId(); ?>"/>

                                    <input type="radio" name="moderation_com" value="Accepter" />Accepter
                                    <input type="radio" name="moderation_com" value="Modifier" />Modifier
                                    <input type="radio" name="moderation_com" value="Supprimer" />Supprimer
                                    <input type="submit" class="btn_formulaire" value="Valider" />
                                </form>
                            </article>
                            <?php
                                    }
                                    print "\n";
                                }
                                print "\n";
                            ?>
                        </fieldset>
                    </div>
                        <?php
                            if (isset($_GET['selectOK'])) {
                        ?>
                        <script>alert("Veuillez sélectionner l'action que vous souhaitez faire svp.");</script>
                        <?php 
                            }
                        ?>
