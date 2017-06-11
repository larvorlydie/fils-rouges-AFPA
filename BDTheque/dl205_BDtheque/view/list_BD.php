                <fieldset id="list_BD">
                    <legend>Nos BD</legend>
                    <?php
                        // Si les tableau de BD ET de thèmes ne sont pas vides
                        // => affichage du fil d'ariane
                        if ($tBD && $tTheme) {
                    ?>
                    <!-- Fil d'ariane du haut de page -->
                    <p><?php print getFilAriane($sLimite, $sNbBD, $sChoix); ?></p>
                    <?php
                        }
                    ?>
                    <?php
                        // Si les tableau de BD ET de thèmes ne sont pas vides
                        // => affichage de la liste
                        if ($tBD && $tTheme) {
                            for ($i = 0; $i < sizeof($tBD); $i++) {
                    ?>
                    <!-- BD n°<?php print $i+1; ?> de la page -->
                    <article>
                        <a href="index.php?choix=consult_BD&idBD=<?php print $tBD[$i]->getId(); ?>">
                            <img src="img/miniBD/<?php print $tBD[$i]->getImage(); ?>" alt="<?php print $tBD[$i]->getTitre(); ?>" />
                        </a>
                        <div id="label_info_list">
                            <p><b>Titre :</b></p>
                            <p><b>Auteur :</b></p>
                            <p><b>Thèmes :</b></p>
                        </div>
                        <div id="info_BD_list">
                            <p><?php print $tBD[$i]->getTitre(); ?></p>
                            <p><?php print $tBD[$i]->getAuteur(); ?></p>
                            <p><?php print $tTheme[$i]; ?></p>
                        </div>
                        <a href="index.php?choix=consult_BD&idBD=<?php print $tBD[$i]->getId(); ?>">Plus d'infos...</a>
                    </article>
                    <?php
                            }
                        }
                        // Sinon, on affiche le message d'information qu'aucune BD
                        // n'a été trouvée
                        else {
                    ?>
                    <p>Aucune BD trouvée.</p>
                    <?php
                        }
                    ?>
                    <!-- -->
                    <?php
                        // Si les tableau de BD ET de thèmes ne sont pas vides
                        // => affichage affichage du fil d'ariane
                        if ($tBD && $tTheme) {
                    ?>
                    <!-- Fil d'ariane du bas de page -->
                    <p><?php print getFilAriane($sLimite, $sNbBD, $sChoix); ?></p>
                    <?php
                        }
                    ?>
                </fieldset>
                <?php print "\n"; ?>