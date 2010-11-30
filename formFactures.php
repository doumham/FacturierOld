<?php
$id_client = '';
include ('classes/interface.class.php');
$myInterface = new interface_();
if(isset($_GET['annee']) && $_GET['annee']){
	$annee = $_GET['annee'];
}
if(isset($_GET['type']) && $_GET['type']){
	$type = $_GET['type'];
	$typeSingulier = substr($type, 0, strlen($type)-1);
}
if(isset($_GET['id']) && $_GET['id']){
	$id = $_GET['id'];
	$selectFactures = mysql_query("SELECT * FROM `factures".ucfirst($type)."` WHERE `id`='$id'") or trigger_error(mysql_error(),E_USER_ERROR);
	$f = mysql_fetch_array($selectFactures);
	extract($f);
	$dateArray = explode("-",$date);
} else {
	if ($type == 'sortantes') {
		$select_no = mysql_query("SELECT `numero` FROM `factures".ucfirst($type)."` ORDER BY `date` DESC, `numero` DESC LIMIT 1") or trigger_error(mysql_error(),E_USER_ERROR);
		$no = mysql_fetch_array($select_no);
		if(mysql_num_rows($select_no) > 0){
			extract($no);
			$numero++;
		}else{
			$numero = 1;
		}
	}
}
if ($type == 'sortantes') {
	if(isset($_GET['id_client']) && $_GET['id_client']){
		$id_client = $_GET['id_client'];
	}
	$selectClients = mysql_query("SELECT `denomination` FROM `clients` WHERE `id_client`='".$id_client."' LIMIT 1") or trigger_error(mysql_error(),E_USER_ERROR);
}
if (!isset($_GET['ajaxed'])) {
	$myInterface->set_title("Facturier – Facture ".$typeSingulier);
	$myInterface->get_header();
}
?>
	<form method="post" action="requetes/insertFacture.php">
		<input name="id" type="hidden" value="<?php if(isset($id)){echo $id;}?>" />
		<input name="type" type="hidden" value="<?php if(isset($type)){echo $type;}?>" />
		<input name="annee" type="hidden" value="<?php if(isset($annee)){echo $annee;}?>" />
<?php if ($type == 'sortantes'): ?>
		<p>
			<label for="numero">Numéro : </label>
			<input name="numero" id="numero" type="number" size="4" value="<?php echo $numero;?>" />
		</p>
<?php endif ?>
		<p>
			<label>Date :</label>
			<input type="number" name="jour" value="<?php if(isset($date) && $date){echo $dateArray[2];}else{echo date("d");}?>" maxlength="2" size="2" />
			<input type="number" name="mois" value="<?php if(isset($date) && $date){echo $dateArray[1];}else{echo date("m");}?>" maxlength="2" size="2" />
			<input type="number" name="lannee" value="<?php if(isset($date) && $date){echo $dateArray[0];}else{echo date("Y");}?>" maxlength="4" size="4" />
		</p>
		<p>
<?php if ($type == 'sortantes'): ?>
<?php $c = mysql_fetch_array($selectClients); ?>
			<label for="denomination">Client : </label>
			<input type="text" name="denomination" id="denomination" value="<?php if(isset($c['denomination']))echo $c['denomination']?>" />
<?php else: ?>
			<label for="denomination">Fournisseur : </label>
			<input type="text" name="denomination" id="denomination" value="<?php if(isset($denomination))echo $denomination?>" autofocus="autofocus" />
<?php endif ?>
		</p>	
		<p>
			<label for="objet">Objet : </label>
			<textarea rows="2" cols="50" name="objet" id="objet"><?php if(isset($objet))echo $objet?></textarea>
		</p>
		<p>
			<label for="montant">Montant : </label>
<?php if (ASSUJETTI_A_LA_TVA): ?>
			<input type="text" name="montant" value="<?php if(isset($montant))echo $montant = strtr($montant, ".", ",");?>" id="montant" required="required" />			
<?php else: ?>
			<input type="text" name="montant_tvac" value="<?php if(isset($montant_tvac))echo $montant_tvac = strtr($montant_tvac, ".", ",");?>" id="montant_tvac" required="required" />			
<?php endif ?>
<?php if (ASSUJETTI_A_LA_TVA): ?>
			<input type="radio" name="htva" value="oui" checked="checked" /> HTVA
			<input type="radio" name="htva" value="non" /> TVAC
<?php else: ?>
			<input type="hidden" name="htva" value="non" />
<?php endif ?>
		</p>
<?php if (ASSUJETTI_A_LA_TVA): ?>
		<p>
			<label for="pourcent_tva">TVA (%) : </label>
			<input type="text" name="pourcent_tva" size="5" value="<?php if(isset($pourcent_tva) && $pourcent_tva){echo strtr($pourcent_tva, ".", ",");}else{echo DEFAULT_TVA;}?>" id="pourcent_tva" />			
		</p>
<?php else: ?>
			<input type="hidden" name="pourcent_tva" value="<?php if(isset($pourcent_tva) && $pourcent_tva){echo strtr($pourcent_tva, ".", ",");}else{echo DEFAULT_TVA;}?>" />
<?php endif ?>
			<input type="hidden" name="deductibilite" value="1" />
		<p>
			<input type="submit" value="Enregistrer" id="validation" />
		</p>
	</form>
<?php $myInterface->get_footer(); ?>