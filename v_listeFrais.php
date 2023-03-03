<div id="contenu">
    <h2>Validation des frais</h2>
    <form action="index.php?uc= &action= " method="post">
        <p>
            <label for="lstVisiteur">Choisir le visiteur</label>
            <select name='lstVisiteur' id='lstVisiteur'>
                <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $id = $unvisiteur['id'];
                        $nom = $unvisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                        if ($id == $idVisiteur){
                ?>

                <option selected value="<?php echo $id; ?>"><?php echo $nom." ".$prenom; ?></option>

                <?php }
                    else{ ?>

                <option value="<?php echo $id; ?>"><?php echo $nom." ".$prenom; ?> </option>
                
                <?php }
                    } ?>

            </select>
        </p>
        <p>
            <label for="txtMois">Mois</label>
            <input type="text" name="txtMois" size="12" value="<?php echo $mois ?>" />
        </p>
        <p class="titre" /><label class="titre">&nbsp;</label><input class="zone" type="submit"value="Valider" size="20" />
    </form>
</div>