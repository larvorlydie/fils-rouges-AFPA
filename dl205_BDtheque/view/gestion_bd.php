                    <div class="pos_gestion">
                        <p style="text-align: center; border: 2px red solid; background-color: white; height: 50px; font-size: 30px; font-weight: bold;">
                            Page en cours de développement : formulaire de modification non actif et ajout du thème non effectif
                        </p>
                        <fieldset>
                            <legend>Gestion des BD</legend>
                            <!-- Bouton d'ajout d'une BD => affiche/cache le formulaire de saisie -->
                            <button type="button" class="btn_formulaire" 
                                    onclick="javascript: afficheMenu('ajout_BD');">
                                        Nouvelle BD
                            </button>
                            <!-- formulaire de saisie d'une nouvelle BD -->
                            <form method="post" id="ajout_BD" action="index.php?choix=verif_ajout_BD">
                                <input type="text" name="titre_BD" placeholder="Titre de la BD" />
                                <br/>
                                <textarea name="resume_BD"></textarea>
                                <br/>
                                <input type="text" name="image_BD" placeholder="Nom du fichier de l'image" />
                                <br/>
                                <select name="auteur_BD">
                                    <option value="">Auteurs</option>
                                    <?php
                                        foreach ($tAuteur as $sAuteur) {
                                    ?>
                                    <option value="<?php print $sAuteur->getId(); ?>"><?php print $sAuteur->getNom(); ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                <br/><br/>
                                <select name="theme_BD">
                                    <option value="">Thème</option>
                                    <?php
                                        foreach ($tTheme as $sTheme) {
                                    ?>
                                    <option value="<?php print $sTheme->getId(); ?>"><?php print $sTheme->getIntitule(); ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                <br/>
                                <input type="submit" class="btn_formulaire" value="Ajouter" />
                            </form>
                            
                            <br/><br/>
                            <!-- Bouton de modification d'une BD => affiche/cache le formulaire de saisie -->
                            <button type="button" class="btn_formulaire" 
                                    onclick="javascript: afficheMenu('modif_BD');">
                                        Modifier une BD
                            </button>
                            <form method="post" id="modif_BD" action="">
                                <input type="text" name="titre_BD" placeholder="Titre de la BD" />
                                <br/>
                                <select>
                                    <option value="">Auteurs</option><!-- valeur par défaut -->
                                </select>
                                <br/><br/>
                                <select>
                                    <option value="">Thème</option><!-- valeur par défaut -->
                                </select>
                                <br/>
                                <input type="submit" class="btn_formulaire" value="Modifier" />
                            </form>
                        </fieldset>
                    </div>
                    <?php
                        if (isset($_GET['ajoutBD'])) {
                            if ($_GET['ajoutBD'] == 1) {
                    ?>
                    <script>alert("Ajout de la BD effectué.");</script>
                    <?php
                            }
                            else {
                    ?>
                    <script>alert("Ajout de la BD non valide, veuillez recommencer svp.");</script>
                    <?php
                            }
                        }
                    ?>