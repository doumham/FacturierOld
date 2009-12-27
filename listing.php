<?php
if (isset($_GET['type']) && !empty($_GET['type'])) {
	$type = $_GET['type'];
	if ($type == 'sortantes') {
		include_once('listingFactures.php');
	} elseif ($type == 'entrantes') {
		include_once('listingFactures.php');
	} elseif($type == 'clients') {
		include_once('listingClients.php');
	} else {
	}
}
?>
