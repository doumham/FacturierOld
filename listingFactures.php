<?php
if (isset($_GET['ajaxed']) && $_GET['ajaxed'] == 1) {
	include ('classes/interface.class.php');
	$myInterface = new interface_();
	$tt_htva = 0;
	$tt_tva	= 0;
	$tt_tvac = 0;
	$ta_htva = 0;
	$ta_tva	= 0;
	$ta_tvac = 0;
	$tg_htva = 0;
	$tg_tva	= 0;
	$tg_tvac = 0;
	$ordre = '';
	$id_client_old = 0;
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
	if(isset($_GET['ordre']) && !empty($_GET['ordre'])){ // classement par client : ordre="clients". Par date : ordre n'existe pas
		$ordre = $_GET['ordre'];
		$req2 = $table.".id_client,";
	}
}
$countFacture = 0;

if($annee && $annee != "all"){
	$date1 = $annee."-00-00";
	$date2 = $annee+1;
	$date2 = $date2."-00-00";
	$req = "WHERE `date`>'$date1' AND `date`<'$date2'";
}

if ($type == "sortantes"):
	$colSpanValue = "5";
else:
	$colSpanValue = "4";
endif;

switch ($type) {
	case 'sortantes':
		$selectFactures = mysql_query("SELECT * FROM `".$table."` LEFT JOIN `clients` ON `".$table."`.`id_client`=`clients`.`id_client` ".$req." ORDER BY ".$req2." `date`, `numero`") or trigger_error(mysql_error(),E_USER_ERROR);
		break;
	
	default:
		$selectFactures = mysql_query("SELECT * FROM `".$table."` ".$req." ORDER BY `date`") or trigger_error(mysql_error(),E_USER_ERROR);
		break;
}
$nombreFactures = mysql_num_rows($selectFactures);
?>
	<form id="listing" action="requetes/traitements.php" method="post">
		<input type="hidden" name="type" value="<?php echo $type ?>" id="type" />
		<input type="hidden" name="table" value="<?php echo $table ?>" />
		<input type="hidden" name="annee" value="<?php echo $annee ?>" id="annee" />
		<input type="hidden" name="ordre" value="<?php echo $ordre ?>" id="ordre" />
		<div class="contenu">
<?php
if ($annee != "all") {
	$annee_h3 = $annee;
}else {
	if (isset($les_annees) && is_array($les_annees) && !empty($les_annees[0])) {
		$annee_h3 = $les_annees[0];
	} else {
		$annee_h3 = date('Y');
	}
}
?>
			<p class="tools">
				<input type="submit" value="Ajouter une facture" id="<?php echo $idBouton ?>" name="boutonAjouter" />
				<input type="submit" value="Supprimer les factures sélectionnées" id="boutonSupprimer" name="boutonSupprimer" />
				<a href="export.php?type=<?php echo $type ?>&amp;annee=<?php echo $annee ?>">Exporter en CSV</a>
				<!-- <input type="hidden" value="<?php if(isset($_GET['ordre']))echo $_GET['ordre'] ?>" name="ordre" />
				<input type="hidden" value="<?php echo $annee ?>" name="annee" /> -->
			</p>
			<table> 
				<tr class="titre_annee">
					<th colspan="<?php echo $colSpanValue+3 ?>"><a href="factures.php?type=<?php echo $type ?>&amp;annee=<?php echo $annee_h3 ?>"><?php echo $annee_h3 ?></a></th>
				</tr>
				<tr class="legende">
					<th><span class="no_print">Outils</span></th>
<?php if ($type == "sortantes"): ?>
					<th class="aR">n°</th>
<?php endif ?>
<?php if ($type == "sortantes"): ?>
					<th><?php if($ordre){?><a href="factures.php?type=<?php echo $type ?>&amp;annee=<?php echo $annee?>" title="Ordonner par dates">Date</a><?php }else{?>Date ↓<?php }?></th>
					<th><?php if(!$ordre){?><a href="factures.php?type=<?php echo $type ?>&amp;annee=<?php echo $annee?>&amp;ordre=clients" title="Ordonner par clients">Client<?php }else{?>Client ↓<?php }?></a></th>
<?php else: ?>
					<th>Date</th>
					<th>Fournisseur</th>
					<th>Objet</th>
<?php endif ?>
<?php if ($type == "sortantes"): ?>
					<th>TVA</th>
<?php endif ?>
<?php if (ASSUJETTI_A_LA_TVA): ?>
					<th class="aR">Montant HTVA</th>
					<th class="aR">Montant TVA</th>
<?php endif ?>
					<th class="aR">Total TVAC</th>
				</tr>
<?php
$client_count=0;
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
		if(!$ordre){
			$trimestreDeLaFacture = ceil(substr($f['date'],5,2)*4/12);
			$anneeDeLaFacture = substr($f['date'],0,4);
		}else{
			if($id_client_old != $f['id_client']){
				$client_count++;
			}
			$id_client_old = $f['id_client'];
			$anneeDeLaFacture = 0;
			$trimestreDeLaFacture = $client_count;
		}
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
	foreach ($value1 as $key_trimestre => $value2) {
		$nombre = count($value2);
		$counter = 0;
		$tt_htva = 0;
		$tt_tva = 0;
		$tt_tvac = 0;
		foreach ($value2 as $key3 => $f) {
?>
<?php if ($counter == "0" && !$ordre){ ?>
				<tr class="titre_trimestre">
					<th colspan="<?php echo $colSpanValue+3 ?>">Trimestre <?php echo $key_trimestre ?></th>
				</tr>
<?php }?>
	<tr class="facture<?php if (isset($f['paid']) && $f['paid'] == 0){echo " unpaid";}?>" id="element_<?php echo $f['id']?>">
		<td>
			<input type="checkbox" name="selectionElements[]" value="<?php echo $f['id'] ?>"<?php if (isset($f['paid']) && $f['paid'] == 1) { echo 'disabled="disabled"'; } ?> />
			<a class="bouton modifier popup" href="<?php echo $form ?>.php?type=<?php echo $type ?>&amp;annee=<?php echo $annee ?>&amp;id=<?php echo $f['id']?>" title="Modifier la facture <?php if($type == 'sortantes')echo $f['numero'] ?>">
				Modifier
			</a> 
<?php if ($type == "sortantes"): ?>
			<a class="bouton imprimer" href="facture.php?id=<?php echo $f['id']?>&amp;print=true&amp;annee=<?php echo $annee ?>" title="Imprimer la facture <?php echo $f['numero'] ?>">
				Imprimer
			</a>
			<a class="bouton paye" id="paid_<?php echo $f['id']?>" href="requetes/togglePaid.php?id=<?php echo $f['id'] ?>&amp;annee=<?php echo $annee ?>&amp;paid=<?php echo $f['paid'] ?>&amp;ordre=<?php echo $ordre ?>" title="<?php if ($f['paid'] == 0) {echo "Marquer la facture ".$f['numero']." comme payée";}else{echo "Marquer la facture ".$f['numero']." comme impayée";} ?>">
				Payée/Impayée
			</a>
			<input type="hidden" value="<?php echo $f['paid'] ?>" name="paye[]"/>
<?php endif ?>
		</td>
<?php if ($type == "sortantes"): ?>
		<td class="aR"><?php echo $f['numero']?></td>
<?php endif ?>
		<td><?php echo strftime("%d %B %Y",strtotime($f['date']))?></td>
<?php if ($type == "sortantes"): ?>
		<td><a href="facture.php?id=<?php echo $f['id']?>" title="<?php echo htmlspecialchars($f['objet'])?>"><?php echo htmlspecialchars($f['denomination'])?></a></td>
<?php else: ?>
		<td><?php echo htmlspecialchars($f['denomination'])?></td>
		<td><?php echo htmlspecialchars($f['objet'])?></td>
<?php endif ?>
<?php if ($type == "sortantes"): ?>
		<td><?php echo $f['tva']?></td>
<?php endif ?>
<?php if (ASSUJETTI_A_LA_TVA): ?>
		<td class="aR"><?php echo number_format($f['montant'], 2, ',', ' ')?> €</td>
		<td class="aR"><?php echo number_format($f['montant_tva'], 2, ',', ' ')?> €</td>
<?php endif ?>
		<td class="aR"><?php echo number_format($f['montant_tvac'], 2, ',', ' ')?> €</td>
	</tr>
<?php
//
$tt_htva += $f['montant'];
$tt_tva += $f['montant_tva'];
$tt_tvac += $f['montant_tvac'];
//
$ta_htva += $f['montant'];
$ta_tva += $f['montant_tva'];
$ta_tvac += $f['montant_tvac'];
//
$tg_htva += $f['montant'];
$tg_tva += $f['montant_tva'];
$tg_tvac += $f['montant_tvac'];
$counter++;
$countFacture++;
if($counter == $nombre){
?>
			<tr class="tot_trimestre">
<?php if ($ordre): ?>
				<th colspan="<?php echo $colSpanValue ?>"><?php echo $f['denomination'] ?></th>
<?php else: ?>
				<th colspan="<?php echo $colSpanValue ?>">Total du trimestre <?php echo $key_trimestre ?></th>
<?php
// Mise en DB des totaux (table trimestre)
$selectTrimestre = mysql_query("SELECT * FROM `trimestres` WHERE `annee`='".substr($f['date'],0,4)."' AND `trimestre`='$key_trimestre' AND `type`='$type'") or trigger_error(mysql_error(),E_USER_ERROR);;
$totauxTrim = mysql_fetch_array($selectTrimestre);
if($totauxTrim['id']){
	if($totauxTrim['montant_htva'] != $tt_htva){
		$idTrim = $totauxTrim['id'];
		$updateTrimestre = mysql_query("UPDATE `trimestres` SET `montant_htva`='$tt_htva', `montant_tva`='$tt_tva', `montant_tvac`='$tt_tvac' WHERE `id`='$idTrim' AND `type`='$type'") or trigger_error(mysql_error(),E_USER_ERROR);;
	}
}else{
	$insert_trimestre = mysql_query("INSERT INTO `trimestres` (`annee`,`trimestre`,`montant_htva`,`montant_tva`,`montant_tvac`,`type`) VALUES ('".substr($f['date'],0,4)."','$key_trimestre','$tt_htva','$tt_tva','$tt_tvac','$type')") or trigger_error(mysql_error(),E_USER_ERROR);;
}
// Fin de mise en DB des totaux
?>
<?php endif ?>
<?php if (ASSUJETTI_A_LA_TVA): ?>
					<th class="aR"><?php echo number_format($tt_htva, 2, ',', ' ')?> €</th>
					<th class="aR"><?php echo number_format($tt_tva, 2, ',', ' ')?> €</th>
<?php endif ?>
					<th class="aR"><?php echo number_format($tt_tvac, 2, ',', ' ')?> €</th>
				</tr>
<?php if (($key_trimestre == "4" && !$ordre)||($annee == date("Y") && $countFacture == $nombreFactures)){ ?>
				<tr class="tot_annee">
					<th colspan="<?php echo $colSpanValue ?>">Total de l'année <?php echo substr($f['date'],0,4) ?></th>
<?php if (ASSUJETTI_A_LA_TVA): ?>
					<th class="aR"><?php echo number_format($ta_htva, 2, ',', ' ')?> €</th>
					<th class="aR"><?php echo number_format($ta_tva, 2, ',', ' ')?> €</th>
<?php endif ?>
					<th class="aR"><?php echo number_format($ta_tvac, 2, ',', ' ')?> €</th>
				</tr>
<?php
if ($annee == "all"): 
	$date_limite = date("Y");
else:
	$date_limite = $annee++;
endif
?>
<?php if (substr($f['date'],0,4) < $date_limite): ?>
	<tr class="titre_annee">
		<th colspan="<?php echo $colSpanValue+3 ?>"><a href="factures.php?type=<?php echo $type ?>&amp;annee=<?php echo substr($f['date']+1,0,4) ?>"><?php echo substr($f['date']+1,0,4) ?></a></th>
	</tr>
<?php endif ?>
<?php
$ta_htva = 0;
$ta_tva = 0;
$ta_tvac = 0;
					}
				}
			}
		}
	}
}
?>
<?php if ($annee == "all"): ?>
			<tr class="tot_general">
				<th colspan="<?php echo $colSpanValue ?>">Total de toutes les années</th>
<?php if (ASSUJETTI_A_LA_TVA): ?>
				<th class="aR"><?php echo number_format($tg_htva, 2, ',', ' ')?> €</th>
				<th class="aR"><?php echo number_format($tg_tva, 2, ',', ' ')?> €</th>
<?php endif ?>
				<th class="aR"><?php echo number_format($tg_tvac, 2, ',', ' ')?> €</th> 
			</tr>
<?php endif ?>
		</table>
		<hr id="bottom" />
	</div>
</form>
