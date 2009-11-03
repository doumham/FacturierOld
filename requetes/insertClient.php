<?php
extract($_POST);
include('../acces/cle.php');
if($id){
	mysql_query("UPDATE `clients` SET `denomination`='$denomination', `nom`='$nom', `prenom`='$prenom', `adresse`='$adresse', `num`='$num', `boite`='$boite', `cp`='$cp', `localite`='$localite', `tel`='$tel', `email`='$email', `site`='$site', `tva`='$tva' WHERE `id_client`='$id'") or die(mysql_error());
}else{
	mysql_query("INSERT INTO `clients`(`denomination`,`nom`,`prenom`,`adresse`,`num`,`boite`,`cp`,`localite`,`tel`,`email`,`site`,`tva`) VALUES ('$denomination','$nom','$prenom','$adresse','$num','$boite','$cp','$localite','$tel','$email','$site','$tva')") or die(mysql_error());
}
header("location:../clients.php");
?>