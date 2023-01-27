    <!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2>
		<?php  
			echo $_SESSION['prenom']."  ".$_SESSION['nom'];
		?>   
		</h2>
         <h3>Comptable</h3>    
      </div>  
        <ul id="menuList">
           <li class="suiviepaiement">
              <a href="index.php?uc=suivrePaiementFrais&action=suiviepaiement" title="suivre un paiement">suivre un paiement</a>
           </li>
         <li class="valier">
               <a href="index.php?uc=validerFrais&action=validerCreationFrais" title="Valider une fiche de frais">Valider une fiche de frais</a>
         </li>
			<li class="smenu">
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
			</li>
         </ul>
        
    </div>
    