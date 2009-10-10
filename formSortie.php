<?php
date_default_timezone_set('Europe/Brussels');
include ('acces/cle.php');
include ('classes/interface.class.php');
$my_interface = new interface_();
if($_GET['annee']){
	$annee=$_GET['annee'];
}
if($_GET['id']){
	$id=$_GET['id'];
	$select_facturesEntrantes=mysql_query("SELECT * FROM facturesEntrantes WHERE id='$id'") or trigger_error(mysql_error(),E_USER_ERROR);
	$d = mysql_fetch_array($select_facturesEntrantes);
	extract($d);
	$date_array=explode("-",$date);
}
?>
<?php $my_interface->set_title("Ajouter une facture entrante"); ?>
<?php $my_interface->get_header(); ?>
<?php include ('include/menu.php');?>
	<div class="contenu">
		<h3>Nouvelle facture entrante</h3>
			<form method="post" action="requetes/insertSortie.php">
				<p>
					<label>Date :</label>
					<input type="text" class="w2em" id="date-1-dd" name="jour" value="<?php if($date){echo $date_array[2];}else{echo date("d");}?>" maxlength="2" size="2" />
					<input type="text" class="w2em" id="date-1-mm" name="mois" value="<?php if($date){echo $date_array[1];}else{echo date("m");}?>" maxlength="2" size="2" />
					<input type="text" class="w4em split-date" id="date-1" name="lannee" value="<?php if($date){echo $date_array[0];}else{echo date("Y");}?>" maxlength="4" size="5" />
				</p>
				<p>
					<label for="objet">Objet : </label>
					<input type="text" name="objet" value="<?php echo $objet?>" />
          <!-- <div style="display: none;" id="laListe"></div>       -->
				</p>
				<p>
					<label for="montant">Montant : </label>
					<input type="text" name="montant" value="<?php echo $montant=strtr($montant, ".", ",");?>" />			
				</p>
				<p>
					<label for="montant">HTVA : </label>
					<input type="radio" name="htva" value="oui" checked="checked" />oui			
					<input type="radio" name="htva" value="non" />non		
				</p>
				<p>
					<label for="pourcent_tva">TVA (%) : </label>
					<input name="pourcent_tva" value="<?php if($pourcent_tva){echo strtr($pourcent_tva, ".", ",");}else{echo "21,00";}?>" />			
				</p>
				<p>
					<label for="pourcent_tva">Déductibilité : </label>
					<input type="radio" name="deductibilite" value="1" <?php if ($deductibilite==1 || !isset($deductibilite)): ?>checked="checked"<?php endif ?> />oui			
					<input type="radio" name="deductibilite" value="0" <?php if ($deductibilite==0 && isset($deductibilite)): ?>checked="checked"<?php endif ?> />non		
				</p>
				<p>
					<label for="validation">Validation : </label>
					<input type="submit" value="Envoyer" />
					<input name="id" type="hidden" value="<?php echo $id?>" />			
					<input name="annee" type="hidden" value="<?php echo $annee?>" />			
				</p>
			</form>
		</div>
<?php $my_interface->get_footer(); ?>