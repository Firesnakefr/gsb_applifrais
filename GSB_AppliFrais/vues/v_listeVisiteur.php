<div id="contenu">
      <h2>Validation des frais</h2>
      <form action="selectionnerVisiteur" method="post">
	     <div class="corpsForm">
		<!-- Combo visiteur -->
		<p>
		<label for="lstVisiteur">Choisir le visiteur</label>
        
		<select name='lstVisiteur' id='lstVisiteur'>
            <?php foreach($lesVisiteurs as $unVisiteur){
                $idVisiteur = $unVisiteur['idVisiteur'];
                $nomVisiteur = $unVisiteur['nom'];
                $prenomVisiteur = $unVisiteur['prenom'];
            ?>


					<option value="<?php echo $idVisiteur?>"><?php echo $nomVisiteur . " " . $prenomVisiteur ?></option>

                <?php } ?>
		</select>
		</p>
		
		<!-- Affichage du mois -->
		<p>
        <label for="txtMois">Mois</label>
		<input type="text" name="txtMois" size="12" placeholder="aaaamm"/><br><br>
		</p>
		
		<p class="titre" /><label class="titre">&nbsp;</label><input class="zone" type="submit" value="Valider"/>
		
      </div>
 
	 </form>