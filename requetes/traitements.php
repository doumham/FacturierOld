<?php
include('../include/config.php');
$redirectPage = "";
$redirectNewFacture = "";
if (isset($_POST['boutonSupprimer']) && $_POST['boutonSupprimer']) {
	$nombreElements = count($_POST["selectionElements"]);
	if ($nombreElements > 0) {
		foreach ($_POST["selectionElements"] as $id) {
			if ($_POST['table'] == 'clients'){
				$req = mysql_query("DELETE FROM `".$_POST['table']."` WHERE `id_client`=$id") or die(mysql_error());
			} else {
				$req = mysql_query("DELETE FROM `".$_POST['table']."` WHERE `id`=$id") or die(mysql_error());
			}
		}
		if (isset($req) && $req) {
			if (isset($_POST['ajaxed']) && !empty($_POST['ajaxed'])) {
				if (count($_POST["selectionElements"]) == 1) {
					echo '{msg:"1 élément supprimé."}';
				} else {
					echo '{msg:"'.count($_POST["selectionElements"]).' éléments supprimés."}';
				}
				exit();
			}
		} else {
			if (isset($_POST['ajaxed']) && !empty($_POST['ajaxed'])) {
				echo '{msg:"Une erreur s’est produite."}';
				exit();
			}
		}
	} else {
		if (isset($_POST['ajaxed']) && !empty($_POST['ajaxed'])) {
			echo '{msg:"Aucun élément sélectionné."}';
			exit();
		}
	}
	$_POST["selectionElements"] = array();
	$nombreElements = 0;
}
switch ($_POST['table']) {
	case 'facturesEntrantes':
		$redirectPage = 'factures.php?type=entrantes';
		$redirectNewFacture = 'formFactures.php?type=entrantes';
		break;
	
	case 'facturesSortantes':
		$redirectPage = 'factures.php?type=sortantes';
		$redirectNewFacture = 'formFactures.php?type=sortantes';
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
	if ($redirectPage == 'clients.php') {
		header('location:../'.$redirectPage);
	} else {
		header('location:../'.$redirectPage.'&annee='.$annee);
	}
}
?>