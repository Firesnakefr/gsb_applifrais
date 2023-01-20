<h3>Ajouter un nouveau frais hors forfait</h3>
<form method='POST' action='index.php?uc=gererFrais&action=validerCreationFrais'>
<table class='tabNonQuadrille'>
<tr>
	<td>Date du frais (jj/mois/aaaa)</td>
	<td>
		<input  type='text' name=dateFrais  size='30' maxlength='45'>
	</td>
</tr>
<tr>
	<td>Description du frais</td>
	<td>
		<input  type='text' name=description  size='50' maxlength='100'>
	</td>
</tr>
<tr>
	<td>Montant engage</td>
	<td>
		<input  type='text' name=montant  size='30' maxlength='45'>
	</td>
</tr>
<tr>
<td>Justificatif</td>
<td><input type='radio' name='justificatif' value='oui'> oui
</td>
<td>
<input type='radio' name='justificatif' value='non'> non
</td>

</tr>

</table>
<input type='submit' value='Valider' name='valider'>
         <input type='reset' value='Annuler' name='annuler'>

</form>
