<?php
include('../include/config.php');
$lesid = $_GET['clients'];
$i = 0;
foreach($lesid as $id) {
	$updateSQL = "UPDATE `clients` SET `ordre`='$i' WHERE `id_client`='$id'";
	$Result1 = mysql_query($updateSQL, $db) or die(mysql_error());
	$i++;
}
?>