<?php
include ('classes/interface.class.php');
$myInterface = new interface_();
if(isset($_GET['annee']) && $_GET['annee']){
	$annee = $_GET['annee'];
}
if(isset($_GET['type']) && $_GET['type']){
	$type = $_GET['type'];
}
if(isset($_GET['id']) && $_GET['id']){
	$id = $_GET['id'];
	$selectFacturesEntrantes = mysql_query("SELECT * FROM `facturesEntrantes` WHERE `id`='$id'") or trigger_error(mysql_error(),E_USER_ERROR);
	$d = mysql_fetch_array($selectFacturesEntrantes);
	extract($d);
	$dateArray=explode("-",$date);
}

if (!isset($_GET['ajaxed'])) {
	$myInterface->set_title("Ajouter une facture entrante");
	$myInterface->get_header();
}
?>
	<form method="post" action="requetes/insertFactureEntrante.php">
		<input name="id" type="hidden" value="<?php if(isset($id)){echo $id;}?>" />			
		<input name="type" type="hidden" value="<?php if(isset($type)){echo $type;}?>" />			
		<input name="annee" type="hidden" value="<?php if(isset($annee)){echo $annee;}?>" />			
		<p>
			<label>Date :</label>
			<input type="number" name="jour" value="<?php if(isset($date) && $date){echo $dateArray[2];}else{echo date("d");}?>" maxlength="2" size="2" />
			<input type="number" name="mois" value="<?php if(isset($date) && $date){echo $dateArray[1];}else{echo date("m");}?>" maxlength="2" size="2" />
			<input type="number" name="lannee" value="<?php if(isset($date) && $date){echo $dateArray[0];}else{echo date("Y");}?>" maxlength="4" size="4" />
		</p>
		<p>
			<label for="denomination">Fournisseur : </label>
			<input type="text" name="denomination" id="denomination" value="<?php if(isset($denomination))echo $denomination?>" autofocus="autofocus" />
			 <!-- <div style="display: none;" id="laListe"></div> -->
		</p>
		<p>
			<label for="objet">Objet : </label>
			<input type="text" name="objet" id="objet" value="<?php if(isset($objet))echo $objet?>" size="40" />
			 <!-- <div style="display: none;" id="laListe"></div> -->
		</p>
		<p>
			<label for="montant">Montant : </label>
			<input type="text" name="montant" value="<?php if(isset($montant))echo $montant = strtr($montant, ".", ",");?>" id="montant" required="required" />			
			<input type="radio" name="htva" value="oui" checked="checked" /> HTVA			
			<input type="radio" name="htva" value="non" /> TVAC		
		</p>
		<p>
			<label for="pourcent_tva">TVA (%) : </label>
			<input name="pourcent_tva" size="5" value="<?php if(isset($pourcent_tva) && $pourcent_tva){echo strtr($pourcent_tva, ".", ",");}else{echo "21,00";}?>" id="pourcent_tva" />			
		</p>
		<p>
			<label>Déductibilité : </label>
			<input type="radio" name="deductibilite" value="1" <?php if (!isset($deductibilite) || $deductibilite == 1): ?>checked="checked"<?php endif ?> />oui			
			<input type="radio" name="deductibilite" value="0" <?php if (isset($deductibilite) && $deductibilite == 0): ?>checked="checked"<?php endif ?> />non		
		</p>
		<p>
			<label for="validation">Validation : </label>
			<input type="submit" value="Envoyer" id="validation" />
		</p>
	</form>
<?php $myInterface->get_footer(); ?>