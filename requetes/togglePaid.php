<?php
include('../acces/cle.php');
$id = $_GET['id'];
$annee = $_GET['annee'];
$ordre = $_GET['ordre'];
if($_GET['paid']=='1'){
	mysql_query("UPDATE `facturesSortantes` SET `paid`=0 WHERE `id`=$id") or die(mysql_error());
}
if($_GET['paid']=='0'){
	mysql_query("UPDATE `facturesSortantes` SET `paid`=1 WHERE `id`=$id") or die(mysql_error());
}
header("location:../facturesSortantes.php?annee=$annee&ordre=$ordre");
?>