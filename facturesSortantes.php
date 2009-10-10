<?php
date_default_timezone_set('Europe/Brussels');
include ('acces/cle.php');
include ('classes/interface.class.php');
$myInterface = new interface_();
if($_GET['annee']){
	$annee = $_GET['annee'];
}else{
	$annee="all";
}
if($annee && $annee != "all"){
  $date1 = $annee."-00-00";
  $date2 = $annee+1;
  $date2 = $date2."-00-00";
	$req="WHERE date>'$date1' AND date<'$date2'";
}
if($_GET['ordre']){ // classement par client : ordre="clients". Par date : ordre n'existe pas
	$ordre = $_GET['ordre'];
	$req2="facturesSortantes.id_client,";
}
$selectFacturesSortantes = mysql_query("
	SELECT * FROM facturesSortantes LEFT JOIN clients ON facturesSortantes.id_client=clients.id_client ".$req." ORDER BY ".$req2." date, numero
	") or trigger_error(mysql_error(),E_USER_ERROR);
$nombreFacturesSortantes = mysql_num_rows($selectFacturesSortantes);
$myInterface->set_title("Factures sortantes");
$myInterface->get_header();
include ('include/menu.php');
include ('include/menu_annees.php');
?>
		<div class="contenu">
<?php
if ($annee != "all") {
  $annee_h3 = $annee;
}else {
  $annee_h3 = $les_annees[0];
}
?>
		<form action="requetes/delete.php" method="post">
			<p>
				<input type="submit" value="Supprimer les factures sélectionnées" id="boutonSupprimer" name="boutonSupprimer" />
				<input type="hidden" value="facturesSortantes" name="table" />
				<input type="hidden" value="<?php echo $_GET['ordre'] ?>" name="ordre" />
				<input type="hidden" value="<?php echo $annee ?>" name="annee" />
			</p>
      <h3><a href="facturesSortantes.php?annee=<?php echo $annee_h3 ?>"><?php echo $annee_h3 ?></a></h3>
      <table> 
        <tr class="legende">
          <th><span class="no_print">Outils</span></th>
          <th class="aR">n°</th>
          <th><?php if($ordre){?><a href="facturesSortantes.php?annee=<?php echo $annee?>" title="Ordonner par dates">Date</a><?php }else{?>Date ↓<?php }?></th>
          <th><?php if(!$ordre){?><a href="facturesSortantes.php?annee=<?php echo $annee?>&amp;ordre=clients" title="Ordonner par clients">Client<?php }else{?>Client ↓<?php }?></a></th>
          <th>TVA</th>
          <th class="aR">Montant HTVA</th>
          <th class="aR">Montant TVA</th>
          <th class="aR">Total TVAC</th>
        </tr>
<?php
$client_count=0;
while($f = mysql_fetch_array($selectFacturesSortantes)){
  if(!$ordre){
    $trimestre_de_la_facture=ceil(substr($f['date'],5,2)*4/12);
    $annee_de_la_facture=substr($f['date'],0,4);
	}else{
		if($id_client_old != $f['id_client']){
			$client_count++;
		}
		$id_client_old = $f['id_client'];
    $annee_de_la_facture=0;
    $trimestre_de_la_facture = $client_count;
	}
  $facture[$annee_de_la_facture][$trimestre_de_la_facture][]=array(
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
if (is_array($facture)) {
foreach ($facture as $key_annee => $value1) {
  $counter_annees++;
  foreach ($value1 as $key_trimestre => $value2) {
    $nombre=count($value2);
    $counter=0;
    unset($tt_htva,$tt_tva,$tt_tvac);
    foreach ($value2 as $key3 => $f) {
?>
<?php if ($counter == "0" && !$ordre){ ?>
        <tr class="titre_trimestre">
          <th colspan="8">Trimestre <?php echo $key_trimestre ?></th>
        </tr>
<?php }?>
  <tr <?php if ($f['paid'] == 0){echo "style='background-image:url(images/fond_li_unpaid.png)'";}?> class="facture" id="element_<?php echo $f['id']?>">
    <td>
        <?php if ($f['paid'] == 0) { ?>
					<input type="checkbox" name="selectionElements[]" value="<?php echo $f['id'] ?>" />
        <?php } else { ?>
					<input type="checkbox" name="selectionElements[]" value="<?php echo $f['id'] ?>" disabled="disabled" />
        <?php } ?>
      <a href="formEntree.php?annee=<?php echo $annee ?>&amp;id=<?php echo $f['id']?>" title="Modifier">
        <img id="icn_edit_<?php echo $f['id']?>" src="images/icn-edit.png" alt="Modifier"/>
      </a> 
      <a href="facture.php?id=<?php echo $f['id']?>&amp;print=true&amp;annee=<?php echo $annee ?>" title="Imprimer">
        <img src="images/print.png" alt="Imprimer"/>
      </a>
      <a id="paid_<?php echo $f['id']?>" href="requetes/togglePaid.php?id=<?php echo $f['id'] ?>&amp;annee=<?php echo $annee ?>&amp;paid=<?php echo $f['paid'] ?>&amp;ordre=<?php echo $ordre ?>" title="<?php if ($f['paid'] == 0) {echo "Marquer comme payée";}else{echo "Marquer comme impayée";} ?>">
        <img src="images/money.png" alt="paid"/>
      </a>
    </td>
    <td class="aR"><?php echo $f['numero']?></td>
    <td><?php echo strftime("%d/%m/%Y",strtotime($f['date']))?></td>
    <td><a href="facture.php?id=<?php echo $f['id']?>" title="<?php echo htmlspecialchars($f['objet'])?>"><?php echo htmlspecialchars($f['denomination'])?></a></td>
    <td><?php echo $f['tva']?></td>
    <td class="aR"><?php echo number_format($f['montant'], 2, ',', ' ')?> €</td>
    <td class="aR"><?php echo number_format($f['montant_tva'], 2, ',', ' ')?> €</td>
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
$count_facture++;
if($counter == $nombre){
?>
      <tr class="tot_trimestre">
<?php if ($ordre): ?>
        <th colspan="5"><?php echo $f['denomination'] ?></th>
<?php else: ?>
        <th colspan="5">Total du trimestre <?php echo $key_trimestre ?></th>
<?php
/////// MISE EN DB DES TOTAUX (TABLE TRIMESTRE) //////////
$select_trimestre = mysql_query("SELECT * FROM trimestres WHERE annee='".substr($f['date'],0,4)."' AND trimestre='$key_trimestre' AND type=1") or trigger_error(mysql_error(),E_USER_ERROR);;
$totaux_trim = mysql_fetch_array($select_trimestre);
if($totaux_trim['id']){
  if($totaux_trim['montant_htva'] != $tt_htva){
    $id_trim = $totaux_trim['id'];
    $update_trimestre = mysql_query("UPDATE trimestres SET montant_htva='$tt_htva',montant_tva='$tt_tva',montant_tvac='$tt_tvac' WHERE id='$id_trim' AND type=1") or trigger_error(mysql_error(),E_USER_ERROR);;
  }
}else{
  $insert_trimestre = mysql_query("INSERT INTO trimestres (annee,trimestre,montant_htva,montant_tva,montant_tvac,type) VALUES ('".substr($f['date'],0,4)."','$key_trimestre','$tt_htva','$tt_tva','$tt_tvac',1)") or trigger_error(mysql_error(),E_USER_ERROR);;
}
//////////////////////////////////////////////////////////
?>
<?php endif ?>
          <th class="aR"><?php echo number_format($tt_htva, 2, ',', ' ')?> €</th>
          <th class="aR"><?php echo number_format($tt_tva, 2, ',', ' ')?> €</th>
          <th class="aR"><?php echo number_format($tt_tvac, 2, ',', ' ')?> €</th>
        </tr>
<?php if (($key_trimestre == "4" && !$ordre)||($_GET['annee'] == date("Y") && $count_facture == $nombreFacturesSortantes)){ ?>
        <tr class="tot_annee">
          <th colspan="5">Total de l'année <?php echo substr($f['date'],0,4) ?></th>
          <th class="aR"><?php echo number_format($ta_htva, 2, ',', ' ')?> €</th>
          <th class="aR"><?php echo number_format($ta_tva, 2, ',', ' ')?> €</th>
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
      </table>
    </div>
    <div class="contenu">
      <h3><a href="facturesSortantes.php?annee=<?php echo substr($f['date']+1,0,4) ?>"><?php echo substr($f['date']+1,0,4) ?></a></h3>
      <table>
<?php endif ?>
<?php
unset($ta_htva,$ta_tva,$ta_tvac);
	        }
	      }
	    }
		}
  }
}
?>
      </table>
		</form>
   </div>
<?php if ($annee == "all"): ?>
<div class="contenu">
  <table>
    <tr class="tot_general">
      <th style="width:66%" colspan="5">Total général</th>
      <th class="aR"><?php echo number_format($tg_htva, 2, ',', ' ')?> €</th>
      <th class="aR"><?php echo number_format($tg_tva, 2, ',', ' ')?> €</th>
      <th class="aR"><?php echo number_format($tg_tvac, 2, ',', ' ')?> €</th> 
    </tr>
  </table>
</div>
<?php endif ?>
<?php $myInterface->get_footer(); ?>
