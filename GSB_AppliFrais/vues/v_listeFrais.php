<div id="contenu">
      <h2>Validation des frais</h2>
      <form action="" method="post">
	     <div class="corpsForm">
		<!-- Combo visiteur -->
		<p>
		<label for="lstVisiteur">Choisir le visiteur</label>
        
		<select name='lstVisiteur' id='lstVisiteur'>
            <?php foreach($lesVisiteurs as $unVisiteur){
                $idVisiteur = $unVisiteur['id'];
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

	 <form action="" method="post">
		
		<div class="corpsForm">
			<!-- Frais forfait -->
			<div style="clear:left;"><h3>Frais au forfait </h3>
					<table style="color:white;" border="1">
						<tr><th></th><th>Repas midi</th><th>Nuitée </th><th>Etape</th><th>Km </th></tr>
						<tr align="center"><th>Quantité</th>
					 
						<td width='80'><input type='text' size='3' name='txtRepas' value=''/></td>
						<td width='80'><input type='text' size='3' name='txtNuitee' value=''/></td>
						<td width='80'> <input type='text' size='3' name='txtEtape' value=''/></td>
						<td width='80'> <input type='text' size='3' name='txtKm' value=''/></td>
						
	
					 
						</tr>
					</table>				 
			<p class="titre" /><label class="titre">&nbsp;</label><input class="zone" type="submit" value="Valider"/>
			</div>
		</div>

	</form>

	<form action="" method="post">
		
		<div class="corpsForm">
			
			<!-- Frais hors-forfait -->	

            <p class="titre" />
			<div style="clear:left;"><h3>Hors Forfait</h3>
				<table style="color:white;" border="1">
					<tr><th>Date</th><th>Libellé </th><th>Montant</th></tr>
					

					<tr align='center'>
					<td width='100'><input type='text' size='12' name='txtDate' value =''/></td>
					<td width='220'><input type='text' size='30' name='txtLibelle' value =''/></td> 
					<td width='90'><input type='text' size='10' name='txtMontant' value =''/></td>
					<td width='90'><a href= ""
                       onclick="return confirm('Voulez-vous vraiment supprimer cette ligne de frais hors forfait ?');"
                       title="Supprimer la ligne de frais hors forfait">Supprimer</a></td>
					<td width='90'><a href= ""
                       onclick="return confirm('Voulez-vous vraiment reporter cette ligne de frais hors forfait ?');"
                       title="Reporter la ligne de frais hors forfait">Reporter</a></td>	
					
				</table>		
			</div>
			<br></br>
			<p class="titre" />
			<div style="clear:left;"><h3>Hors classification</h3>
			<b>Nombres de justificatifs : </b><input type='text' class='zone' size='8' name='txtNbJustificatifs' value=''><br>
			<b>Montant total de la fiche : </b><input type='text' class='zone' size='8' name='txtMontant' value=''>	
			<p class="titre" /><label class="titre">&nbsp;</label><input class="zone" type="submit" value="Valider"/>
			       <input id="annuler" type="reset" value="Annuler" size="20" />
			</div>	
	

		</div>
	</form>


 
	 
  </div>