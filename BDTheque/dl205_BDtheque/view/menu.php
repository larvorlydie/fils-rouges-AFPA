                <?php
                    // Import des managers
                    include_once 'model/ThemeManager.class.php';
                    include_once 'model/AuteurManager.class.php';
                    
                    // Lancement des managers
                    $sManListTheme = new ThemeManager();
                    $sManListAuteur = new AuteurManager();

                    // Récupération de la liste des thèmes et des auteurs
                    $tListTheme = $sManListTheme->getListTheme();
                    $tListAuteur = $sManListAuteur->getListAuteur();
                    
                    // Fermeture des managers
                    $sManListAuteur = null;
                    $sManListTheme = null;
                ?>
                <nav id="menu">
                    <!-- Bouton Accueil -->
                    <button type="button" class="bouton_menu" 
                            onclick="javascript: location.assign('index.php');">
                        Accueil
                    </button>
                    
                    <?php
                        // Si connexion en tant qu'administrateur => affichage du menu de gestion
                        if (isset($_SESSION['id'])){
                    ?>
                    <!-- Bouton Accueil Administrateur -->
                    <button type="button" class="bouton_menu" 
                            onclick="javascript: location.assign('index.php?choix=accueil_admin');">
                        Accueil admin
                    </button>
                    <?php
                        }
                    ?>
                    <?php
                        // Si la page affichée n'est pas la liste complète des BD
                        // => Affichage du bouton permettant d'y aller
                        if ($sChoix !== "liste_BD") {
                    ?>
                    <!-- Bouton retour à la liste complète -->
                    <button type="button" class="bouton_menu" 
                            onclick="javascript: location.assign('index.php?choix=liste_BD');">
                        Liste des BD
                    </button>
                    <?php
                        }
                    ?>
                    <!-- Bouton Rechercher -->
                    <button type="button" class="bouton_menu" 
                            onclick="javascript: afficheMenu('menu_recherche');">
                        Rechercher
                    </button>
                    
                    <!-- Menu de recherche -->
                    <div id="menu_recherche">
                        <br/><br/>
                        <form method="post" action="index.php?choix=recherche_BD&recherche=nouvelle">
                            <!-- Recherche par titre -->
                            <label for="recherche_titre">Par titre :</label><br/>
                            <input type="text" name="recherche_titre" /><br/><br/>
                            
                            <!-- Recherche par auteur -->
                            <label for="recherche_auteur">Par auteur :</label><br/><br/>
                            <select name="recherche_auteur">
                                <option value="">Tous les auteurs</option>
                                <?php
                                    foreach ($tListAuteur as $sListAuteur) {
                                ?>
                                <option value="<?php print $sListAuteur->getNom(); ?>"><?php print $sListAuteur->getNom(); ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <br/><br/>
                        
                            <!-- Recherche par thème -->
                            <label for="recherche_theme">Par thème :</label><br/><br/>
                            <select name="recherche_theme">
                                <option value="">Tous les thèmes</option>
                                <?php
                                    foreach ($tListTheme as $sListTheme) {
                                ?>
                                <option value="<?php print $sListTheme->getIntitule(); ?>"><?php print $sListTheme->getIntitule(); ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <br/><br/>

                            <input type="submit" class="btn_formulaire" value="Valider" />
                        </form>
                    </div>
                    
                    <?php
                        // Si connexion en tant qu'administrateur => affichage du menu de gestion
                        if (isset($_SESSION['id'])){
                    ?>
                    <!-- Menu de gestion -->
                    <button type="button" class="bouton_menu" 
                            onclick="javascript: afficheMenu('menu_gestion');">
                        Gestion
                    </button>
                    
                    <div id="menu_gestion">
                        <br/>
                        <!-- gestion des BD -->
                        <button type="button" class="btn_menu_gestion" 
                                onclick="javascript: location.assign('index.php?choix=gestion_BD');">
                            BD
                        </button>
                        <br/><br/>
                        <!-- gestion des auteurs -->
                        <button type="button" class="btn_menu_gestion" 
                                onclick="javascript: location.assign('index.php?choix=gestion_auteur');">
                            Auteurs
                        </button>
                        <br/><br/>
                        <!-- gestion des thèmes -->
                        <button type="button" class="btn_menu_gestion" 
                                onclick="javascript: location.assign('index.php?choix=gestion_theme');">
                            Thèmes
                        </button>
                        <br/><br/>
                        <!-- gestion des commentaires -->
                        <button type="button" class="btn_menu_gestion" 
                                onclick="javascript: location.assign('index.php?choix=gestion_com');">
                            Commentaires
                        </button>
                    </div>
                    <!-- Bouton Déconnexion -->
                    <button type="button" class="bouton_menu" 
                            onclick="javascript: location.assign('index.php?choix=deconnexion');">
                        Déconnexion
                    </button>
                    <?php
                        }
                    ?>
                    <!-- Bouton Retour -->
                    <button type="button" class="bouton_menu" 
                            onclick="javascript: history.back();">
                        Retour
                    </button>
                </nav>
                <?php print "\n"; ?>