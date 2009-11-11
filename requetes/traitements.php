<?php
include('../acces/cle.php');
$redirectPage = "";
$redirectNewFacture = "";
if (isset($_POST['boutonSupprimer']) && $_POST['boutonSupprimer']) {
	$nombreElements = count($_POST["selectionElements"]);
	if ($nombreElements > 0) {
		foreach ($_POST["selectionElements"] as $id) {
			if ($_POST['table'] == 'clients'){
				mysql_query("DELETE FROM `".$_POST['table']."` WHERE `id_client`=$id") or die(mysql_error());
			} else {
				mysql_query("DELETE FROM `".$_POST['table']."` WHERE `id`=$id") or die(mysql_error());
			}
		}
		if (isset($_POST['ajaxed']) && !empty($_POST['ajaxed'])) {
			echo '{msg:"Élément supprimé."}';
		}
	} else {
		echo "Aucun élément sélectionné.";
	}
	$_POST["selectionElements"] = array();
	$nombreElements = 0;
}
switch ($_POST['table']) {
	case 'facturesEntrantes':
		$redirectPage = 'facturesEntrantes.php';
		$redirectNewFacture = 'formFacturesEntrantes.php';
		break;
	
	case 'facturesSortantes':
		$redirectPage = 'facturesSortantes.php';
		$redirectNewFacture = 'formFacturesSortantes.php';
		break;
	
	default:
		$redirectPage = 'clients.php';
		$redirectNewFacture = 'formClient.php';
		break;
}
if (isset($_POST['boutonAjouter']) && $_POST['boutonAjouter']) {
	header('location:../'.$redirectNewFacture);
	exit();
} else {
	if (isset($_POST['annee']) && !empty($_POST['annee'])) {
		$annee = $_POST['annee'];
	} else {
		$annee = "";
	}
	header('location:../'.$redirectPage.'?annee='.$annee);
}
?>