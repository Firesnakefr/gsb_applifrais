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
                    }
                ?>
                <option value="<?php echo $id; ?>"><?php echo $nom." ".$prenom; ?> </option>
            </select>
        </p>
        <p>
            <label for="txtMois">Mois</label>
            <input type="text" name="txtMois" size="12" value="<?php echo $mois ?>" />
        </p>
        <p class="titre" /><label class="titre">&nbsp;</label><input class="zone" type="submit"value="Valider" size="20" />
    </form>
</div>

<form action="index.php?uc=validerFrais&action=modifierFraisForfait" method="post">
    <div class="corpsForm">
        <input type="hidden" name = "txtVisiteur" value="<?php echo $idVisiteur ?>">
        <!-- Frais forfait -->
        <div style="clear:left;"><h3>Frais au forfait </h3>
            <table style="color:white;" border="1">
                <tr><th></th>
                    <?php foreach($lesFraisForfait as $unFrais){
                        $libelle = $unFrais['libelle'];
                    ?>

                    <th><?php echo $libelle ?></th>

                    <?php } ?>

                    <th></th>
                </tr>

                <tr align="center"><th>Quantité</th>

                <?php foreach ($lesFraisForfait as $unFrais){
                    $idFrais = $unFrais['idfrais'];
                    $quantite = $unFrais['quantite'];
                } ?>

                <td width='80'> <input type="text" id="idFrais" name="lesFrais" size="10"maxlength="5" value="<?php echo $quantite?>" ></td>

                </tr>

            </table>
            <p class="titre" /><label class="titre">&nbsp;</label><input class="zone"type="submit" value="Valider"/>
        </div>
    </div>
</form>

<form action="index.php?uc=valiserFrais&action=validerFrais" method="post">
    <div class="corpsForm">
       <input type="hidden" name = "txtVisiteur" value="<?php echo $idVisiteur?>">
        <!-- Frais hors-forfait -->
        <p class="titre" />
        <div style="clear:left;"><h3>Hors Forfait</h3>
            <table style="color:white;" border="1">
                <tr><th>Date</th><th>Libellé </th><th>Montant</th></tr>
                <?php foreach($lesFraisHorsForfait as $unFraisHorsForfait){
                    $libelle = $unFraisHorsForfait['libelle'];
                    $date = $unFraisHorsForfait['dateFrais'];
                    $montant = $unFraisHorsForfait['montant'];
                    $id = $unFraisHorsForfait['id'];
                } ?>
                <tr>
                <td width='100'><input type='text' size='12' name='txtDate' value ='<?php echo $date ?>'/></td>
                <td width='220'><input type='text' size='30' name='txtLibelle' value ='<?php echo $libelle ?>'/></td>
                <td width='90'><input type='text' size='10' name='txtMontant' value ='<?php echo $montant ?>'/></td>
                <td width='90'><a href= "index.php?uc=validerFrais&action=supprimerFraisHorsForfait&idFrais=<?php echo $id ?>&txtVisiteur=<?php echo $idVisiteur ?>"onclick="return confirm('Voulez-vous vraiment supprimer cette ligne de fraishors forfait ?');"title="Supprimer la ligne de frais hors forfait">Supprimer</a></td>
                <td width='90'><a href= "index.php?uc=validerFrais&action=reporterFriasHorsForfait&idFrais=<?php echo $id ?>&txtVisiteur=<?php echo $idVisiteur ?>"onclick="return confirm('Voulez-vous vraiment reporter cette ligne de frais horsforfait ?');"title="Reporter la ligne de frais hors forfait">Reporter</a></td>
                </tr>
                <?php
                    {}
                ?>
                <tr align='center'>
            </table>
        </div>
        <br></br>
        <p class="titre" />
            <div style="clear:left;"><h3>Hors classification</h3>
                <b>Nombres de justificatifs : </b><input type='text' class='zone' size='8'name='txtNbJustificatifs' value= ><br>
                <b>Montant total de la fiche : </b><input type='text' class='zone' size='8'name='txtMontantFiche' value= >
                <p class="titre" /><label class="titre">&nbsp;</label><input class="zone"type="submit" value="Valider"/>
                <input id="annuler" type="reset" value="Annuler" size="20" />
            </div>
    </div>
</form>