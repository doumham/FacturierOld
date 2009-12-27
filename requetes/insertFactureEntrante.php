<?php
extract($_POST);
$date = $lannee."-".$mois."-".$jour;
$montant = strtr($montant, ",", ".");
$pourcent_tva = strtr($pourcent_tva, ",", ".");
if($htva == "non"){
	$montant = $montant/($pourcent_tva/100+1);
}
$montant_tva = $montant*$pourcent_tva/100;
$montant_tvac = $montant*($pourcent_tva/100+1);
include('../include/config.php');
if($id){
	$req = mysql_query("UPDATE `facturesEntrantes` SET date='$date',`denomination`='$denomination',`objet`='$objet',`montant`='$montant',`pourcent_tva`='$pourcent_tva',`montant_tva`='$montant_tva',`montant_tvac`='$montant_tvac',`deductibilite`='$deductibilite' WHERE `id`='$id'") or die(mysql_error());
}else{
	$req = mysql_query("INSERT INTO `facturesEntrantes`(`date`,`denomination`,`objet`,`montant`,`pourcent_tva`,`montant_tva`,`montant_tvac`,`deductibilite`) VALUES  ('$date','$denomination','$objet','$montant','$pourcent_tva','$montant_tva','$montant_tvac','$deductibilite')") or die(mysql_error());
}
if (isset($_POST['ajaxed']) && !empty($_POST['ajaxed'])) {
	if ($req) {
		echo '{msg:"Facture enregistrée."}';
	} else {
		echo '{msg:"Une erreur s’est produite."}';
	}
}else{
	header("location:../factures.php?type=entrantes&annee=$lannee");
}
?>