<?php
extract($_POST);
$date=$lannee."-".$mois."-".$jour;
$montant=strtr($montant, ",", ".");
$pourcent_tva=strtr($pourcent_tva, ",", ".");
if($htva=="non"){
	$montant=$montant/($pourcent_tva/100+1);
}
$montant_tva=$montant*$pourcent_tva/100;
$montant_tvac=$montant*($pourcent_tva/100+1);
include('../acces/cle.php');
if($id){
	mysql_query("UPDATE `facturesEntrantes` SET date='$date',`objet`='$objet',`montant`='$montant',`pourcent_tva`='$pourcent_tva',`montant_tva`='$montant_tva',`montant_tvac`='$montant_tvac',`deductibilite`='$deductibilite' WHERE `id`='$id'") or die(mysql_error());
}else{
	mysql_query("INSERT INTO `facturesEntrantes`(`date`,`objet`,`montant`,`pourcent_tva`,`montant_tva`,`montant_tvac`,`deductibilite`) VALUES  ('$date','$objet','$montant','$pourcent_tva','$montant_tva','$montant_tvac','$deductibilite')") or die(mysql_error());
}
header("location:../facturesEntrantes.php?annee=".$lannee);
?>