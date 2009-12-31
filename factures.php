<?php
include ('classes/interface.class.php');
$myInterface = new interface_();
if (isset($_GET['type']) && $_GET['type'] == 'entrantes') {
	$type = "entrantes";
	$table = "facturesEntrantes";
	$form = "formFactures";
	$idBouton = "boutonAjouterFactureEntrante";
} else {
	$type = "sortantes";
	$table = "facturesSortantes";
	$form = "formFactures";
	$idBouton = "boutonAjouterFactureSortante";
}

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
}else{
	$annee = "all";
}
if(isset($_GET['ordre']) && !empty($_GET['ordre'])){ // classement par client : ordre="clients". Par date : ordre n'existe pas
	$ordre = $_GET['ordre'];
	$req2 = $table.".id_client,";
}
$myInterface->set_title("Factures sortantes");
$myInterface->get_header();
include_once ('include/menu_annees.php');
include_once ('include/onglets.php');
?>
<div id="Liste">
<?php include_once ("listingFactures.php"); ?>
</div>
<?php $myInterface->get_footer(); ?>
