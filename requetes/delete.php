<?php
include('../acces/cle.php');
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
	} else {
		echo "Aucun élément sélectionné.";
	}
	$_POST["selectionElements"] = array();
	$nombreElements = 0;
  // echo json_encode($monCalendrier);
}
switch ($_POST['table']) {
	case 'depenses':
		$redirectPage = 'sorties.php';
		break;
	
	case 'factures':
		$redirectPage = 'entrees.php';
		break;
	
	default:
		$redirectPage = 'clients.php';
		break;
}
header('location:../'.$redirectPage.'?annee='.$_POST["annee"].'&ordre='.$_POST['ordre']);
?>