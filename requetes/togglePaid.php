<?php
include('../include/config.php');
$id = $_GET['id'];
$annee = $_GET['annee'];
$ordre = $_GET['ordre'];
$requ = false;
if($_GET['paid'] == '1'){
	$req = mysql_query("UPDATE `facturesSortantes` SET `paid` = 0 WHERE `id`=$id");
}
if($_GET['paid'] == '0'){
	$req = mysql_query("UPDATE `facturesSortantes` SET `paid` = 1 WHERE `id`=$id");
}
if (isset($_GET['ajaxed']) && !empty($_GET['ajaxed'])) {
	if ($req) {
		if ($_GET['paid']=='1') {
			echo '{"msg":"Facture marquée comme impayée."}';
		} else {
			echo '{"msg":"Facture marquée comme payée."}';
		}
	} else {
		echo '{"msg":"Une erreur s’est produite."}';
	}
}else{
	header("location:../factures.php?type=sortantes&annee=$annee&ordre=$ordre");
}
?>