<?php
extract($_POST);
include('../acces/cle.php');
if($id){
	mysql_query("UPDATE `utilisateur` SET 
		`denomination`='$denomination', 
		`prenom`='$prenom', 
		`nom`='$nom', 
		`legende`='$legende', 
		`adresse`='$adresse', 
		`numero`='$numero', 
		`boite`='$boite', 
		`codepostal`='$codepostal', 
		`localite`='$localite', 
		`telephone`='$telephone', 
		`fax`='$fax', 
		`portable`='$portable', 
		`email`='$email', 
		`site`='$site', 
		`tva`='$tva', 
		`comptebancaire`='$comptebancaire', 
		`iban`='$iban', 
		`bic`='$bic' 
		WHERE `id`='$id'") or die(mysql_error());
}
header("location:../formUtilisateur.php");
?>