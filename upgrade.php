<?php
include ('classes/interface.class.php');
$myInterface = new interface_();
$selectFactures = mysql_query("SELECT * FROM `facturesSortantes` WHERE `paid`=1") or trigger_error(mysql_error(),E_USER_ERROR);
while($f = mysql_fetch_array($selectFactures)){
	$req = mysql_query("UPDATE `facturesSortantes` SET `amount_paid`='".$f['montant_tvac']."' WHERE `id`='".$f['id']."'") or die(mysql_error());
}
?>
