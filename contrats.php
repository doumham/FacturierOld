<?php
include ('classes/interface.class.php');
$myInterface = new interface_();
$type = "contrats";
$table = "contrats";
$form = "formContrats";
$idBouton = "boutonAjouterContrat";

$tt_htva = 0;
$tt_tva  = 0;
$tt_tvac = 0;
$ta_htva = 0;
$ta_tva  = 0;
$ta_tvac = 0;
$tg_htva = 0;
$tg_tva  = 0;
$tg_tvac = 0;
$count_facture = 0;
$ordre = '';
$id_client_old = 0;
$counter_annees = 0;
$req = '';
$req2 = '';

if(isset($_GET['annee']) && !empty($_GET['annee'])){
	$annee = $_GET['annee'];
} else {
	$annee = "all";
}
if(isset($_GET['ordre']) && !empty($_GET['ordre'])){ // classement par client : ordre="clients". Par date : ordre n'existe pas
	$ordre = $_GET['ordre'];
	$req2 = $table.".id_client,";
}
$myInterface->set_title("Facturier – Contrats");
$myInterface->get_header();
include_once ('include/menu_annees.php');
include_once ('include/onglets.php');
?>
<div id="Liste">
<?php include_once ("listingContrats.php"); ?>
</div>
<?php $myInterface->get_footer(); ?>
