<?php
include('../include/config.php');
foreach ($_POST as $key => $value) {
	$$key = preg_replace("/'/", '’', $value);
}
$date = $lannee."-".$mois."-".$jour;
$pourcent_tva = strtr($pourcent_tva, ",", ".");
$amount_paid = strtr($amount_paid, ",", ".");
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

// Gestion Client pour contrat
$selectClient = mysql_query("SELECT `id_client` FROM `clients` WHERE `denomination`='".$denomination."' LIMIT 1") or trigger_error(mysql_error(),E_USER_ERROR);
$f = mysql_fetch_array($selectClient);
if(!empty($f['id_client'])) {
	$id_client = $f['id_client'];
} else {
	$req = mysql_query("INSERT INTO `clients`(`denomination`) VALUES ('$denomination')") or die(mysql_error());
	$id_client = mysql_insert_id();
}

if(isset($id) && !empty($id)){ // update
	$req = mysql_query("UPDATE `contrats` SET `id_usr`='$id_usr',`id_client`='$id_client',`date`='$date',`numero`='$numero',`objet`='$objet',`montant`='$montant',`pourcent_tva`='$pourcent_tva',`montant_tva`='$montant_tva',`montant_tvac`='$montant_tvac',`amount_paid`='$amount_paid' WHERE `id`='$id'");
} else {
	$req = mysql_query("INSERT INTO `contrats`(`id_usr`,`id_client`,`date`,`numero`,`objet`,`montant`,`pourcent_tva`,`montant_tva`,`montant_tvac`,`amount_paid`) VALUES ('$id_usr','$id_client','$date','$numero','$objet','$montant','$pourcent_tva','$montant_tva','$montant_tvac','$amount_paid')");
}
if (isset($_POST['ajaxed']) && !empty($_POST['ajaxed'])) {
	if ($req) {
		echo '{"msg":"Contrat enregistré."}';
	} else {
		echo '{"msg":"Une erreur s’est produite."}';
	}
}else{
	header('location:../contrats.php?annee='.$lannee.'#bottom');
}
?>