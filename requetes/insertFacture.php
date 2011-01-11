<?php
include('../include/config.php');
extract($_POST);
$date = $lannee."-".$mois."-".$jour;
$pourcent_tva = strtr($pourcent_tva, ",", ".");
if (ASSUJETTI_A_LA_TVA) {
	$montant = strtr($montant, ",", ".");
	if(isset($htva) && $htva == "non"){
		$montant = $montant/($pourcent_tva/100+1);
	}
	$montant_tvac = $montant*($pourcent_tva/100+1);
} else {
	$montant_tvac = strtr($montant_tvac, ",", ".");
	$montant = $montant_tvac/($pourcent_tva/100+1);
}
$montant_tva = $montant*$pourcent_tva/100;

// Gestion Client pour facture sortante
if (isset($type) && $type == 'sortantes') {
	$selectClient = mysql_query("SELECT `id_client` FROM `clients` WHERE `denomination`='".$denomination."' LIMIT 1") or trigger_error(mysql_error(),E_USER_ERROR);
	$f = mysql_fetch_array($selectClient);
	if(!empty($f['id_client'])) {
		$id_client = $f['id_client'];
	} else {
		$req = mysql_query("INSERT INTO `clients`(`denomination`) VALUES ('$denomination')") or die(mysql_error());
		$id_client = mysql_insert_id();
	}
}

if(isset($id) && !empty($id)){ // update
	if (isset($type) && $type == 'entrantes') {
		$req = mysql_query("UPDATE `facturesEntrantes` SET `date`='$date',`denomination`='$denomination',`objet`='$objet',`montant`='$montant',`pourcent_tva`='$pourcent_tva',`montant_tva`='$montant_tva',`montant_tvac`='$montant_tvac',`deductibilite`='$deductibilite' WHERE `id`='$id'") or die(mysql_error());
	} else {
		$req = mysql_query("UPDATE `facturesSortantes` SET `id_usr`='$id_usr',`id_client`='$id_client',`date`='$date',`numero`='$numero',`objet`='$objet',`montant`='$montant',`pourcent_tva`='$pourcent_tva',`montant_tva`='$montant_tva',`montant_tvac`='$montant_tvac' WHERE `id`='$id'");
	}
} else {
	if ($type == 'entrantes') { //insert
		$req = mysql_query("INSERT INTO `facturesEntrantes`(`date`,`denomination`,`objet`,`montant`,`pourcent_tva`,`montant_tva`,`montant_tvac`,`deductibilite`) VALUES ('$date','$denomination','$objet','$montant','$pourcent_tva','$montant_tva','$montant_tvac','$deductibilite')") or die(mysql_error());
	} else {		
		$req = mysql_query("INSERT INTO `facturesSortantes`(`id_usr`,`id_client`,`date`,`numero`,`objet`,`montant`,`pourcent_tva`,`montant_tva`,`montant_tvac`) VALUES ('$id_usr','$id_client','$date','$numero','$objet','$montant','$pourcent_tva','$montant_tva','$montant_tvac')");
	}
}
if (isset($_POST['ajaxed']) && !empty($_POST['ajaxed'])) {
	if ($req) {
		echo '{"msg":"Facture enregistrée."}';
	} else {
		echo '{"msg":"Une erreur s’est produite."}';
	}
}else{
	header('location:../factures.php?type='.$type.'&annee='.$lannee.'#bottom');
}
?>