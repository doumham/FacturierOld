<?php
extract($_POST);
include('../include/config.php');
if($id){
	$req = mysql_query("UPDATE `utilisateur` SET 
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
if (isset($_POST['ajaxed']) && !empty($_POST['ajaxed'])) {
	if ($req) {
		echo '{msg:"Modifications enregistrées."}';
	} else {
		echo '{msg:"Une erreur s’est produite."}';
	}
}else{
	header("location:../formUtilisateur.php");
}
?>