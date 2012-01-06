<?php
include('../include/config.php');
extract($_POST);
if(isset($denomination) && empty($denomination)) {
	$denomination = $nom.' '.$prenom;
}
if($id){
	$req = mysql_query("UPDATE `clients` SET `denomination`='$denomination', `nom`='$nom', `prenom`='$prenom', `adresse`='$adresse', `num`='$num', `boite`='$boite', `cp`='$cp', `localite`='$localite', `pays`='$pays', `tel`='$tel', `email`='$email', `site`='$site', `tva`='$tva' WHERE `id_client`='$id'") or die(mysql_error());
} else {
	$req = mysql_query("INSERT INTO `clients`(`denomination`,`nom`,`prenom`,`adresse`,`num`,`boite`,`cp`,`localite`,`pays`,`tel`,`email`,`site`,`tva`) VALUES ('$denomination','$nom','$prenom','$adresse','$num','$boite','$cp','$localite','$pays','$tel','$email','$site','$tva')") or die(mysql_error());
}
if (isset($_POST['ajaxed']) && !empty($_POST['ajaxed'])) {
	if ($req) {
		echo '{"msg":"Client enregistré."}';
	} else {
		echo '{"msg":"Une erreur s’est produite."}';
	}
} else {
	header("location:../clients.php");
}
?>