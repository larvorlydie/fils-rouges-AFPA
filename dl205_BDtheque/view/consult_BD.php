                <div id="pos_consult">
                    <!-- Informations sur la BD sélectionnée -->
                    <fieldset id="BD">
                        <legend id="titre_BD"><?php print $sBD->getTitre(); ?></legend>
                        <img src="img/couvBD/<?php print $sBD->getImage(); ?>" alt="Couverture de la BD" id="couv_BD" />
                        <section id="info_BD_consult">
                            <div id="intitule_info_BD">
                                <p>Auteurs :</p>
                                <p class="themes_consult">Thèmes :</p>
                                <p>Résumé :</p>
                            </div>
                            <div id="inclusion_info_BD">
                                <p><?php print $sBD->getAuteur(); ?></p>
                                <p class="themes_consult"><?php print $sTheme; ?></p>
                                <p><?php print $sBD->getResume(); ?></p>
                            </div>
                        </section>
                    </fieldset>

                    <fieldset id="Comment">
                        <!-- Commentaires liés à la BD sélectionnée -->
                        <legend>Commentaires</legend>
                        <section id="saisie_com">
                            <!-- Formulaire de saisie d'un nouveau commentaire -->
                            <form method="post" action="index.php?choix=nouveau_com">
                                <input type="hidden" name="idBd" value="<?php print $sIdBD; ?>" />
                                
                                <div id="com_pseudo_saisie">
                                    <label for="pseudo">Pseudo :</label>
                                    <input type="text" name="pseudo" placeholder="Votre pseudo" required="required" />
                                </div>

                                <div id="com_texte_saisie">
                                    <label for="texte">Commentaire :</label>
                                    <textarea name="texte" placeholder="Laissez votre commentaire ici..." required="required"></textarea>
                                </div>
                                <div id="com_valid_saisie">
                                    <input type="submit" class="btn_formulaire" value="Valider" />
                                </div>
                            </form>
                        </section>
                        
                        <section id="com_affiche">
                            <?php
                                // S'il y a des commentaires validés à afficher
                                if ($tCom) {
                                    print "\n";
                                    for ($i = 0; $i < sizeof($tCom); $i++) {
                            ?>
                            <!-- Commentaire n°<?php print $i+1; ?> -->
                            <article class="com" id="com_<?php print $i+1; ?>">
                                <h1><?php print $tCom[$i]->getAuteur(); ?></h1>
                                <h1 class="date"><?php print $tCom[$i]->getdate(); ?></h1>
                                <p><?php print $tCom[$i]->getTexte(); ?></p>
                            </article>
                            <?php
                                    }
                                }
                                // Sinon => affichage d'un message prévenant qu'il n'y en a pas
                                else {
                                    print "\n";
                            ?>
                            <article class="com">
                                <p>
                                    Aucun commentaire n'a été laissé pour cette BD! <br/>
                                    Soyez le premier!
                                </p>
                            </article>
                            <?php
                                    print "\n";
                                }
                            ?>
                        </section>
                    </fieldset>
                </div>
                <?php 
                    print "\n";
                    
                    // Si redirection sur la page après saisie d'un commentaire
                    if (isset($_GET['insertion'])) {
                        // => message de confirmation si le commentaire c'est bien insérer
                        if ($_GET['insertion'] == 1) {
                ?>
                <script>alert("Votre commentaire a bien été enregistré.");</script>
                <?php            
                        }
                        // Sinon => message d'information qu'une erreur est survenue
                        else {
                ?>
                <script>alert("Erreur : votre commentaire n'a pas pu être enregistré.");</script>
                <?php
                        }
                    }
                ?>