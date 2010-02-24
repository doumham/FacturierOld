<?php
if (isset($_GET['type']) && !empty($_GET['type'])) {
	$type = $_GET['type'];
	if($type == 'clients') {
		include_once('listingClients.php');
	} else {
		include_once('listingFactures.php');
	}
}
?>
