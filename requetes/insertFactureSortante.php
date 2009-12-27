<?php
extract($_POST);
$date = $lannee."-".$mois."-".$jour;
$montant = strtr($montant, ",", ".");
$pourcent_tva = strtr($pourcent_tva, ",", ".");
$montant_tva = $montant*$pourcent_tva/100;
$montant_tvac = $montant*($pourcent_tva/100+1);
$req = false;
include('../include/config.php');
if($id){
	$req = mysql_query("UPDATE `facturesSortantes` SET `id_client`='$id_client',`date`='$date',`numero`='$numero',`objet`='$objet',`montant`='$montant',`pourcent_tva`='$pourcent_tva',`montant_tva`='$montant_tva',`montant_tvac`='$montant_tvac' WHERE `id`='$id'");
}else{
	$req = mysql_query("INSERT INTO `facturesSortantes`(`id_client`,`date`,`numero`,`objet`,`montant`,`pourcent_tva`,`montant_tva`,`montant_tvac`) VALUES  ('$id_client','$date','$numero','$objet','$montant','$pourcent_tva','$montant_tva','$montant_tvac')");
}
if (isset($_POST['ajaxed']) && !empty($_POST['ajaxed'])) {
	if ($req) {
		echo '{msg:"Facture enregistrée."}';
	} else {
		echo '{msg:"Une erreur s’est produite."}';
	}
}else{
	header("location:../factures.php?type=sortantes&annee=$lannee");
}
?>