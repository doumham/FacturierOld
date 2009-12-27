<?php
include ('acces/cle.php');
include ('classes/interface.class.php');
$myInterface = new interface_();
if($_GET['type']){
	$type = $_GET['type'];
} else {
	$type = "sortantes";
}
if($_GET['annee']){
	$annee = $_GET['annee'];
}else{
	$annee="all";
}
?>
<?php $myInterface->set_title("Clients"); ?>
<?php $myInterface->get_header(); ?>
<?php include('include/header.php');?>
<div id="Liste">
<?php include_once ("include/listingClients.php"); ?>
</div>
<?php $myInterface->get_footer(); ?>