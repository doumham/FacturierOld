<?php
ob_start();
include ('classes/interface.class.php');
$myInterface = new interface_();

if(isset($_GET['id']) && !empty($_GET['id'])){
	$id = $_GET['id'];
	$selectFactureSortante = mysql_query("SELECT * FROM `contrats` LEFT JOIN `clients` ON `contrats`.`id_client`=`clients`.`id_client` WHERE `id`='$id'") or trigger_error(mysql_error(),E_USER_ERROR);
} else {
	header("location:./");
}
$f = mysql_fetch_array($selectFactureSortante);
extract($f);

$selectUtilisateur = mysql_query("SELECT * FROM `utilisateur` WHERE `id`='$id_usr'") or trigger_error(mysql_error(),E_USER_ERROR);
$utilisateur = mysql_fetch_array($selectUtilisateur);
$selectClients = mysql_query("SELECT * FROM clients") or trigger_error(mysql_error(),E_USER_ERROR);
if($tva){
	$tva = "TVA : ".$tva;
}
// if(isset($_GET['print']) && $_GET['print'] == true){
// 	$printing = ' onload="window.print();document.location.href=\'factures.php?type=sortantes&amp;annee='.$_GET['annee'].'#bottom\';"';
// } else {
// 	$printing = "";
// }
$pageTitle = $utilisateur['denomination'].', contrat '.strftime("%y",strtotime($date)).'-'.$numero;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $pageTitle ?></title>
		<link href="css/impression.css" rel="stylesheet" type="text/css" />
	</head>
	<body<?php //echo $printing?>>
		<div id="global">
			<div id="entete">
				<h1><?php echo $utilisateur['denomination']; ?></h1>
					<p><?php echo $utilisateur['legende']; ?></p>
					<address>
						<p><?php echo $utilisateur['adresse']; ?> <?php echo $utilisateur['numero']; ?><br />
						<?php echo $utilisateur['codepostal']; ?> <?php echo $utilisateur['localite']; ?><br />
						</p><p>
						Tél. : <?php echo $utilisateur['telephone']; ?><br />
						E-mail : <?php echo $utilisateur['email']; ?><br />
						</p><p>
						TVA <?php echo $utilisateur['tva']; ?><br />
						IBAN : <?php echo $utilisateur['iban']; ?><br />
						BIC : <?php echo $utilisateur['bic']; ?>
						</p>
					</address>
			</div>
			<h2>Contrat n&deg; <?php echo strftime("%y",strtotime($date))?>-<?php echo $numero?></h2>
			<address id="destinataire"> <?php echo $denomination?><br /> <?php echo $adresse?> <?php echo $num?><br /> <?php echo $cp?>  <?php echo $localite?><br /> <?php echo $tva?></address>
			<p id="date"><?php echo strftime("%A %d %B %Y",strtotime($date))?></p>
			<h3>Objet : </h3>
			<p id="objet"><?php echo nl2br($objet)?></p>
			<table id="montants">
				<tr id="montant">
					<td></td>
					<td class="chiffre"> <?php echo number_format($montant, 2, ',', ' ')?> &euro;</td>
				</tr>
				<tr id="montant_tva">
					<td>TVA  <?php echo number_format($pourcent_tva, 2, ',', ' ')?> % : </td>
					<td class='chiffre'> <?php echo number_format($montant_tva, 2, ',', ' ')?> &euro;</td>
				</tr>
				<tr id="montant_tvac">
					<td>Total TVAC : </td>
					<td class='chiffre'> <?php echo number_format($montant_tvac, 2, ',', ' ')?> &euro;</td>
				</tr>
			</table>
		</div>
	</body>
</html>
<?php
$maFacture = ob_get_contents();
ob_end_clean();
if (isset($_GET['pdf']) && $_GET['pdf'] == true) {
	require_once("dompdf/dompdf_config.inc.php");
	$dompdf = new DOMPDF();
	$dompdf->set_paper('A4');
	$dompdf->load_html($maFacture);
	$dompdf->render();
	$dompdf->stream($pageTitle.'.pdf');
} else {
	echo $maFacture;
}

?>