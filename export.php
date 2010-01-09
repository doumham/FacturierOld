<?php
$counter_annees = 0;
$req = '';
$req2 = '';
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
if(isset($_GET['annee'])){
	$annee = $_GET['annee'];
}else{
	$annee = "all";
}
$countFacture = 0;

if($annee && $annee != "all"){
	$date1 = $annee."-00-00";
	$date2 = $annee+1;
	$date2 = $date2."-00-00";
	$req = "WHERE `date`>'$date1' AND `date`<'$date2'";
}

include ('classes/interface.class.php');
$myInterface = new interface_();
header("Content-type: application/csv");
header("Content-disposition: filename=factures_".$type."_".$annee.".csv");

switch ($type) {
	case 'sortantes':
		$selectFactures = mysql_query("SELECT * FROM `".$table."` LEFT JOIN `clients` ON `".$table."`.`id_client`=`clients`.`id_client` ".$req." ORDER BY ".$req2." `date`, `numero`") or trigger_error(mysql_error(),E_USER_ERROR);
		break;
	
	default:
		$selectFactures = mysql_query("SELECT * FROM `".$table."` ".$req." ORDER BY `date`") or trigger_error(mysql_error(),E_USER_ERROR);
		break;
}
$outputCSV = '';
if ($type == 'sortantes') {
	$outputCSV .= 'n°;';  // sortantes: 1
}
$outputCSV .= 'Date;';  // sortantes: 2  entrantes: 1
if ($type == 'sortantes') {
	$outputCSV .= 'Client;';  // sortantes: 3
} else {
	$outputCSV .= 'Fournisseur;'; // entrantes: 2
	$outputCSV .= 'Objet;'; // entrantes: 3
}
if ($type == 'sortantes') {
	$outputCSV .= 'TVA;';  // sortantes: 4
}
if (ASSUJETTI_A_LA_TVA) {
	$outputCSV .= 'Montant HTVA;';  // sortantes: 5  entrantes: 4
	$outputCSV .= 'Montant TVA;';  // sortantes: 6  entrantes: 5
}
$outputCSV .= 'Total TVAC'."\n";  // sortantes: 7  entrantes: 6

if ($type == 'entrantes') {
	while($f = mysql_fetch_array($selectFactures)){
		$trimestreDeLaFacture = ceil(substr($f['date'],5,2)*4/12);
		$anneeDeLaFacture = substr($f['date'],0,4);
		$facture[$anneeDeLaFacture][$trimestreDeLaFacture][] = array(
			'id'=>$f['id'],
			'date'=>$f['date'],
			'denomination'=>$f['denomination'],
			'objet'=>$f['objet'],
			'montant'=>$f['montant'],
			'montant_tva'=>$f['montant_tva'],
			'montant_tvac'=>$f['montant_tvac'],
			'deductibilite'=>$f['deductibilite']
		);
	}
} else {
	while($f = mysql_fetch_array($selectFactures)){
		$trimestreDeLaFacture = ceil(substr($f['date'],5,2)*4/12);
		$anneeDeLaFacture = substr($f['date'],0,4);
		$facture[$anneeDeLaFacture][$trimestreDeLaFacture][] = array(
			'id'=>$f['id'],
			'numero'=>$f['numero'],
			'date'=>$f['date'],
			'id_client'=>$f['id_client'],
			'denomination'=>$f['denomination'],
			'objet'=>$f['objet'],
			'tva'=>$f['tva'],
			'montant'=>$f['montant'],
			'montant_tva'=>$f['montant_tva'],
			'montant_tvac'=>$f['montant_tvac'],
			'paid'=>$f['paid']
		);
	}
}

if (isset($facture) && is_array($facture)) {
	foreach ($facture as $key_annee => $value1) {
		$counter_annees++;
		
		$outputCSV .= $key_annee.';;;';
		if (ASSUJETTI_A_LA_TVA) $outputCSV .= ';;';
		if ($type == 'sortantes') $outputCSV .= ';';
		$outputCSV .= "\n";
		
		foreach ($value1 as $key_trimestre => $value2) {
			$nombre = count($value2);
			$counter = 0;
			foreach ($value2 as $key3 => $f) {
				if ($counter == "0"){
					$outputCSV .= 'Trimestre '.$key_trimestre.';;;';
					if (ASSUJETTI_A_LA_TVA) $outputCSV .= ';;';
					if ($type == 'sortantes') $outputCSV .= ';';
					$outputCSV .= "\n";
				}
				if ($type == "sortantes") {
					$outputCSV .= $f['numero'].';';
				}
				$outputCSV .= strftime("%d %B %Y",strtotime($f['date'])).';';
				if ($type == "sortantes") {
					$outputCSV .= '"'.htmlspecialchars($f['denomination']);
					if (isset($f['paid']) && $f['paid'] == 0){
						$outputCSV .= " (impayée)";
					}
					$outputCSV .= '";';
				} else {
					$outputCSV .= htmlspecialchars($f['denomination']).';';
					$outputCSV .= htmlspecialchars($f['objet']).';';
				}
				if ($type == "sortantes") {
					$outputCSV .= $f['tva'].';';
				}
				if (ASSUJETTI_A_LA_TVA) {
					$outputCSV .= number_format($f['montant'], 2, ',', '').' €;';
					$outputCSV .= number_format($f['montant_tva'], 2, ',', '').' €;';
				}
				$outputCSV .= number_format($f['montant_tvac'], 2, ',', '').' €'."\n";
				$counter++;
				$countFacture++;
			}
		}
	}
}
echo $outputCSV;
?>
