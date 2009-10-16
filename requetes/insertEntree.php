<?php
extract($_POST);
$date = $lannee."-".$mois."-".$jour;
$montant = strtr($montant, ",", ".");
$pourcent_tva = strtr($pourcent_tva, ",", ".");
$montant_tva = $montant*$pourcent_tva/100;
$montant_tvac = $montant*($pourcent_tva/100+1);
include('../acces/cle.php');
if($id){
	mysql_query("UPDATE `facturesSortantes` SET `id_client`='$id_client',`date`='$date',`numero`='$numero',`objet`='$objet',`montant`='$montant',`pourcent_tva`='$pourcent_tva',`montant_tva`='$montant_tva',`montant_tvac`='$montant_tvac' WHERE `id`='$id'") or die(mysql_error());
}else{
	mysql_query("INSERT INTO `facturesSortantes`(`id_client`,`date`,`numero`,`objet`,`montant`,`pourcent_tva`,`montant_tva`,`montant_tvac`) VALUES  ('$id_client','$date','$numero','$objet','$montant','$pourcent_tva','$montant_tva','$montant_tvac')") or die(mysql_error());
}
header("location:../facturesSortantes.php?annee=".$lannee);
?>