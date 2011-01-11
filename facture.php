<?php
include ('classes/interface.class.php');
$myInterface = new interface_();

if(isset($_GET['id']) && !empty($_GET['id'])){
	$id = $_GET['id'];
	$selectFactureSortante = mysql_query("SELECT * FROM `facturesSortantes` LEFT JOIN `clients` ON `facturesSortantes`.`id_client`=`clients`.`id_client` WHERE `id`='$id'") or trigger_error(mysql_error(),E_USER_ERROR);
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
if(isset($_GET['print']) && $_GET['print'] == true){
	$printing = ' onload="window.print();document.location.href=\'factures.php?type=sortantes&amp;annee='.$_GET['annee'].'#bottom\';"';
} else {
	$printing = "";
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $utilisateur['denomination']; ?>, facture <?php echo strftime("%y",strtotime($date))?>-<?php echo $numero?></title>
		<link href="css/impression.css" rel="stylesheet" type="text/css" />
	</head>
	<body<?php echo $printing?>>
		<div id="global">
			<div id="entete">
				<h1><?php echo $utilisateur['denomination']; ?></h1>
					<p><?php echo $utilisateur['legende']; ?></p>
					<address>
						<p><?php echo $utilisateur['adresse']; ?>, <?php echo $utilisateur['numero']; ?><br />
						<?php echo $utilisateur['codepostal']; ?> <?php echo $utilisateur['localite']; ?><br />
						</p><p>
						Tél. : <?php echo $utilisateur['telephone']; ?><br />
						E-mail : <?php echo $utilisateur['email']; ?><br />
						</p><p>
						TVA <?php echo $utilisateur['tva']; ?><br />
						Compte bancaire : <?php echo $utilisateur['comptebancaire']; ?>
						</p>
					</address>
			</div>
			<h2>Facture n&deg; <?php echo strftime("%y",strtotime($date))?> - <?php echo $numero?></h2>
			<address> <?php echo $denomination?><br /> <?php echo $adresse?>, <?php echo $num?><br /> <?php echo $cp?>  <?php echo $localite?><br /> <?php echo $tva?></address>
			<p id="date"><?php echo strftime("%A %d %B %Y",strtotime($date))?></p>
			<h3>Objet : </h3>
			<p id="objet"><?php echo nl2br($objet)?></p>
			<div id="montants">
				<p id="montant"><span class="chiffre"> <?php echo number_format($montant, 2, ',', ' ')?> &euro;</span></p>
				<p id="montant_tva">TVA  <?php echo number_format($pourcent_tva, 2, ',', ' ')?> % : <span class='chiffre'> <?php echo number_format($montant_tva, 2, ',', ' ')?> &euro;</span></p>
				<p id="montant_tvac">Total TVAC : <span class='chiffre'> <?php echo number_format($montant_tvac, 2, ',', ' ')?> &euro;</span></p>
			</div>
		</div>	
	</body>
</html>