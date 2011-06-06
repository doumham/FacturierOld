<?php
include ('classes/interface.class.php');
$myInterface = new interface_();
if(isset($_GET['type']) && !empty($_GET['type'])){
	$type = $_GET['type'];
} else {
	$type = "sortantes";
}
if(isset($_GET['annee']) && !empty($_GET['annee'])){
	$annee = $_GET['annee'];
} else {
	$annee="all";
}
?>
<?php $myInterface->set_title("Clients"); ?>
<?php 
$myInterface->get_header();
include_once ('include/onglets.php');
?>
<div id="Liste">
<?php include_once ("listingClients.php"); ?>
</div>
<?php $myInterface->get_footer(); ?>