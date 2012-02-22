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
	$req = '';
	$req2 = '';
	$table = "contrats";
	$form = "formContrats";
	$idBouton = "boutonAjouterContrat";
	if(isset($_GET['annee'])){
		$annee = $_GET['annee'];
	} else {
		$annee = "all";
	}
	if(isset($_GET['ordre']) && !empty($_GET['ordre'])){ // classement par client : ordre="clients". Par date : ordre n'existe pas
		$ordre = $_GET['ordre'];
		$req2 = $table.".id_client,";
	}
}
$colSpanValue = 6;
$countContrat = 0;

if($annee && $annee != "all"){
	$date1 = $annee."-00-00";
	$date2 = $annee+1;
	$date2 = $date2."-00-00";
	$req = "WHERE `date`>'$date1' AND `date`<'$date2'";
}
$selectContrats = mysql_query("SELECT * FROM `".$table."` LEFT JOIN `clients` ON `".$table."`.`id_client`=`clients`.`id_client` ".$req." ORDER BY ".$req2." `date`, `numero`") or trigger_error(mysql_error(),E_USER_ERROR);
$nombreContrats = mysql_num_rows($selectContrats);
?>
	<form id="listing" action="requetes/traitements.php" method="post">
		<input type="hidden" name="table" value="<?php echo $table ?>" />
		<input type="hidden" name="type" value="contrats" id="type" />
		<input type="hidden" name="annee" value="<?php echo $annee ?>" id="annee" />
		<input type="hidden" name="ordre" value="<?php echo $ordre ?>" id="ordre" />
		<div class="contenu">
<?php
if ($annee != "all") {
	$annee_h3 = $annee;
} else {
	if (isset($les_annees) && is_array($les_annees) && !empty($les_annees[0])) {
		$annee_h3 = $les_annees[0];
	} else {
		$annee_h3 = date('Y');
	}
}
?>
			<p class="tools">
				<a href="formContrats.php?annee=<?php echo $annee ?>" id="<?php echo $idBouton ?>" class="button orange medium" title="Nouveau contrat">Nouveau contrat</a>
				<input type="submit" value="Supprimer les contrats sélectionnés" id="boutonSupprimer" name="boutonSupprimer" class="button mediumGrey medium" />
				<!-- <a href="export.php?annee=<?php echo $annee ?>" id="boutonExport" class="button mediumGrey medium">Exporter en CSV</a> -->
			</p>
			<table>
				<tr class="titre_annee">
					<th colspan="<?php echo $colSpanValue ?>"><a href="contrats.php?annee=<?php echo $annee_h3 ?>"><?php echo $annee_h3 ?></a></th>
				</tr>
				<tr class="legende">
					<th><span class="no_print">Outils</span></th>
					<th class="aR">n°</th>
					<th><?php if($ordre){?><a href="contrats.php?annee=<?php echo $annee?>" title="Ordonner par dates">Date</a><?php }else{?>Date ↓<?php }?></th>
					<th><?php if(!$ordre){?><a href="contrats.php?annee=<?php echo $annee?>&amp;ordre=clients" title="Ordonner par clients">Client<?php }else{?>Client ↓<?php }?></a></th>
					<th>Objet</th>
					<th>TVA</th>
<?php if (ASSUJETTI_A_LA_TVA): ?>
					<th class="aR">Montant HTVA</th>
					<th class="aR">Montant TVA</th>
<?php endif ?>
					<th class="aR">Total TVAC</th>
				</tr>
<?php
$client_count=0;
while ($f = mysql_fetch_array($selectContrats)) {
	if (!$ordre) {
		// trimestre
		$trimestreDuContrat = ceil(substr($f['date'],5,2)*4/12);
		$anneeDuContrat = substr($f['date'],0,4);
	} else {
		if($id_client_old != $f['id_client']){
			$client_count++;
		}
		$id_client_old = $f['id_client'];
		$anneeDuContrat = 0;
		$trimestreDuContrat = $client_count;
	}
	$contrat[$anneeDuContrat][$trimestreDuContrat][] = array(
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
		'amount_paid'=>$f['amount_paid'],
		);
}

if (isset($contrat) && is_array($contrat)) {
foreach ($contrat as $key_annee => $value1) {
	foreach ($value1 as $key_trimestre => $value2) {
		$nombre = count($value2);
		$counter = 0;
		$tt_htva = 0;
		$tt_tva = 0;
		$tt_tvac = 0;
		$tt_a_payer = 0;
		foreach ($value2 as $key3 => $f) {
?>
<?php if ($counter == "0" && !$ordre){ ?>
				<tr class="titre_trimestre">
					<th colspan="<?php echo $colSpanValue ?>">Trimestre <?php echo $key_trimestre ?></th>
				</tr>
<?php }?>
	<tr id="element_<?php echo $f['id']?>">
		<td>
			<input type="checkbox" name="selectionElements[]" value="<?php echo $f['id'] ?>"<?php if (isset($f['amount_paid']) && $f['amount_paid'] > 0) { echo 'disabled="disabled"'; } ?> />
			<a class="button small mediumGrey voir" href="contrat.php?id=<?php echo $f['id']?>" title="<?php echo htmlspecialchars($f['objet'])?>">
				Voir
			</a> 
			<!-- <a class="bouton imprimer" href="contrat.php?id=<?php echo $f['id']?>&amp;print=true&amp;annee=<?php echo $annee ?>" title="Imprimer la contrat <?php echo $f['numero'] ?>">
				Imprimer
			</a> -->
			<a class="button small grey" href="contrat.php?id=<?php echo $f['id']?>&amp;pdf=true&amp;annee=<?php echo $annee ?>" title="Exporter la contrat <?php echo $f['numero'] ?> au format PDF">
				PDF
			</a>
		</td>
		<td class="aR"><?php echo $f['numero']?></td>
		<td><?php echo strftime("%d %B %Y",strtotime($f['date']))?></td>
		<td><?php echo $myInterface->truncate(htmlspecialchars($f['denomination']), 40); ?></td>
		<td><a class="popup" href="<?php echo $form ?>.php?annee=<?php echo $annee ?>&amp;id=<?php echo $f['id']?>" title="<?php echo $myInterface->truncate(htmlspecialchars($f['objet']), 60)?>"><?php if(trim($f['objet'])){ echo $myInterface->truncate(htmlspecialchars($f['objet']), 60);  } else { echo '<em>Pas d’objet</em>'; }?></a></td>
		<td><?php echo $f['tva']?></td>
<?php if (ASSUJETTI_A_LA_TVA): ?>
		<td class="aR"><?php echo number_format($f['montant'], 2, ',', ' ')?> €</td>
		<td class="aR"><?php echo number_format($f['montant_tva'], 2, ',', ' ')?> €</td>
<?php endif ?>
		<td class="aR"><?php echo number_format($f['montant_tvac'], 2, ',', ' ')?> €</td>
	</tr>
<?php
// Totaux par trimestre
$tt_htva += $f['montant'];
$tt_tva += $f['montant_tva'];
$tt_tvac += $f['montant_tvac'];
if(isset($f['amount_paid']) && $f['amount_paid'] != $f['montant_tvac']) {
	$tt_a_payer -= $f['montant_tvac']-$f['amount_paid'];
}
// Totaux par année
$ta_htva += $f['montant'];
$ta_tva += $f['montant_tva'];
$ta_tvac += $f['montant_tvac'];
// Totaux toutes années confondues
$tg_htva += $f['montant'];
$tg_tva += $f['montant_tva'];
$tg_tvac += $f['montant_tvac'];
$counter++;
$countContrat++;
if($counter == $nombre){
?>
			<tr class="tot_trimestre">
<?php if ($ordre): ?>
				<th colspan="<?php echo $colSpanValue ?>"><?php echo $f['denomination'] ?></th>
<?php else: ?>
				<th colspan="<?php echo $colSpanValue ?>">Total du trimestre <?php echo $key_trimestre ?></th>
<?php endif ?>
<?php if (ASSUJETTI_A_LA_TVA): ?>
					<th class="aR"><?php echo number_format($tt_htva, 2, ',', ' ')?> €</th>
					<th class="aR"><?php echo number_format($tt_tva, 2, ',', ' ')?> €</th>
<?php endif ?>
					<th class="aR"><?php echo number_format($tt_tvac, 2, ',', ' ')?> €</th>
				</tr>
<?php if (($key_trimestre == "4" && !$ordre)||($annee == date("Y") && $countContrat == $nombreContrats)){ ?>
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
		<th colspan="<?php echo $colSpanValue ?>"><a href="contrats.php?annee=<?php echo substr($f['date']+1,0,4) ?>"><?php echo substr($f['date']+1,0,4) ?></a></th>
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
