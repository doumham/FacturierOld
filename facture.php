<?php
date_default_timezone_set('Europe/Brussels');
setlocale (LC_ALL, 'fr_FR');
include ('acces/cle.php');
include ('include/config.php');
if($_GET['id']){
	$id=$_GET['id'];
	$select_factures=mysql_query("
		SELECT * FROM factures LEFT JOIN clients ON factures.id_client=clients.id_client WHERE id='$id'") or trigger_error(mysql_error(),E_USER_ERROR);
}else{
	header("location:entrees.php");
}
$f = mysql_fetch_array($select_factures);
extract($f);
$select_clients=mysql_query("SELECT * FROM clients") or trigger_error(mysql_error(),E_USER_ERROR);
if($tva){
	$tva="TVA : ".$tva;
}
if($_GET['print']==true){
	$printing=" onload=\"window.print();document.location.href='entrees.php?annee=".$_GET['annee']."';\"";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo $c_denomination ?>, facture <?php echo strftime("%y",strtotime($date))?>-<?php echo $numero?></title>
		<link href="css/impression.css" rel="stylesheet" type="text/css" />
	</head>
	<body<?php echo $printing?>>
		<div id="global">
			<div id="entete">
				<h1><?php echo $c_denomination?></h1>
					<p><?php echo $c_legende?></p>
					<address>
						<p><?php echo $c_adresse?>, <?php echo $c_numero?><br />
						<?php echo $c_cp?> <?php echo $c_localite?><br />
						</p><p>
						Tél. : <?php echo $c_tel?><br />
						E-mail : <?php echo $c_email?><br />
						</p><p>
						TVA <?php echo $c_tva?><br />
						Compte bancaire : <?php echo $c_cb?>
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