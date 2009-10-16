<?php
date_default_timezone_set('Europe/Brussels');
include ('acces/cle.php');
include ('classes/interface.class.php');
$myInterface = new interface_();
if($_GET['annee']){
	$annee = $_GET['annee'];
}
if($_GET['id']){
	$id = $_GET['id'];
	$selectFacturesEntrantes = mysql_query("SELECT * FROM facturesEntrantes WHERE id='$id'") or trigger_error(mysql_error(),E_USER_ERROR);
	$d = mysql_fetch_array($selectFacturesEntrantes);
	extract($d);
	$dateArray=explode("-",$date);
}
?>
<?php $myInterface->set_title("Ajouter une facture entrante"); ?>
<?php $myInterface->get_header(); ?>
	<div class="contenu">
		<h3>Nouvelle facture entrante</h3>
			<form method="post" action="requetes/insertSortie.php">
				<p>
					<label>Date :</label>
					<input type="text" class="w2em" id="date-1-dd" name="jour" value="<?php if(isset($date) && $date){echo $dateArray[2];}else{echo date("d");}?>" maxlength="2" size="2" />
					<input type="text" class="w2em" id="date-1-mm" name="mois" value="<?php if(isset($date) && $date){echo $dateArray[1];}else{echo date("m");}?>" maxlength="2" size="2" />
					<input type="text" class="w4em split-date" id="date-1" name="lannee" value="<?php if(isset($date) && $date){echo $dateArray[0];}else{echo date("Y");}?>" maxlength="4" size="5" />
				</p>
				<p>
					<label for="objet">Objet : </label>
					<input type="text" name="objet" value="<?php if(isset($objet))echo $objet?>" />
          <!-- <div style="display: none;" id="laListe"></div>       -->
				</p>
				<p>
					<label for="montant">Montant : </label>
					<input type="text" name="montant" value="<?php if(isset($montant))echo $montant = strtr($montant, ".", ",");?>" />			
				</p>
				<p>
					<label for="montant">HTVA : </label>
					<input type="radio" name="htva" value="oui" checked="checked" />oui			
					<input type="radio" name="htva" value="non" />non		
				</p>
				<p>
					<label for="pourcent_tva">TVA (%) : </label>
					<input name="pourcent_tva" value="<?php if(isset($pourcent_tva) && $pourcent_tva){echo strtr($pourcent_tva, ".", ",");}else{echo "21,00";}?>" />			
				</p>
				<p>
					<label for="pourcent_tva">Déductibilité : </label>
					<input type="radio" name="deductibilite" value="1" <?php if (!isset($deductibilite) || $deductibilite == 1): ?>checked="checked"<?php endif ?> />oui			
					<input type="radio" name="deductibilite" value="0" <?php if (isset($deductibilite) && $deductibilite == 0): ?>checked="checked"<?php endif ?> />non		
				</p>
				<p>
					<label for="validation">Validation : </label>
					<input type="submit" value="Envoyer" />
					<input name="id" type="hidden" value="<?php if(isset($id))echo $id?>" />			
					<input name="annee" type="hidden" value="<?php if(isset($annee))echo $annee?>" />			
				</p>
			</form>
		</div>
<?php $myInterface->get_footer(); ?>