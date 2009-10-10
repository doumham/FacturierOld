<?php
date_default_timezone_set('Europe/Brussels');
include ('acces/cle.php');
include ('classes/interface.class.php');
$myInterface = new interface_();
if($_GET['annee']){
	$annee = $_GET['annee'];
}else{
	$annee = "all";
}
if($annee && $annee!="all"){
  $date1 = $annee."-00-00";
  $date2 = $annee+1;
  $date2 = $date2."-00-00";
	$req = "WHERE date>'$date1' AND date<'$date2'";
}
$selectFacturesEntrantes=mysql_query("
	SELECT * FROM facturesEntrantes ".$req." ORDER BY date
	") or trigger_error(mysql_error(),E_USER_ERROR);?>
<?php $myInterface->set_title("Factures entrantes"); ?>
<?php $myInterface->get_header(); ?>
<?php include ('include/menu.php');?>
<?php include ('include/menu_annees.php');?>
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
				<input type="hidden" value="facturesEntrantes" name="table" />
				<input type="hidden" value="<?php echo $annee ?>" name="annee" />
			</p>
      <h3><a href="facturesEntrantes.php?annee=<?php echo $annee_h3 ?>"><?php echo $annee_h3 ?></a></h3>
    <table> 
      <tr class="legende">
        <th><span class="no_print">Outils</span></th>
        <th>Date</th>
        <th>Objet</th>
        <th class="aR">Montant HTVA</th>
        <th class="aR">Montant TVA</th>
        <th class="aR">Total TVAC</th>
      </tr>
<?php
while($f = mysql_fetch_array($selectFacturesEntrantes)){
  $trimestre=ceil(substr($f['date'],5,2)*4/12);
  $premier_indice=substr($f['date'],0,4);
  $facture[$premier_indice][$trimestre][]=array(
    'id'=>$f['id'],
    'numero'=>$f['numero'],
    'date'=>$f['date'],
    'id_client'=>$f['id_client'],
    'denomination'=>$f['denomination'],
    'objet'=>$f['objet'],
    'montant'=>$f['montant'],
    'montant_tva'=>$f['montant_tva'],
    'montant_tvac'=>$f['montant_tvac'],
    'deductibilite'=>$f['deductibilite']
    );
}
if (is_array($facture)) {
foreach ($facture as $key_annee => $value1) {
  $counter_annees++;
  foreach ($value1 as $key_trimestre => $value2) {
    $nombre=count($value2);
    $counter=0;
    unset($tt_htva,$tt_tva,$tt_tvac,$tt_htva_d,$tt_tva_d,$tt_tvac_d);
    foreach ($value2 as $key3 => $f) {
?>
<?php if ($counter=="0"){ ?>
        <tr class="titre_trimestre">
          <th colspan="8">Trimestre <?php echo $key_trimestre ?></th>
        </tr>
<?php }?>
  <tr <?php if ($f['deductibilite']==0){echo "style='background-image:url(images/fond_li_unpaid.png)'";}?> class="facture" id="element_<?php echo $f['id']?>">
    <td>
      <?php if ($f['paid'] == 0) { ?>
			<input type="checkbox" name="selectionElements[]" value="<?php echo $f['id'] ?>" />
      <?php } ?>
      <a href="formSortie.php?annee=<?php echo $annee ?>&amp;id=<?php echo $f['id']?>" title="Modifier">
        <img id="icn_edit_<?php echo $f['id']?>" src="images/icn-edit.png" alt="Modifier"/>
      </a> 
    </td>
    <td><?php echo strftime("%d/%m/%Y",strtotime($f['date']))?></td>
    <td><?php echo $f['objet']?></td>
    <td class="aR"><?php echo number_format($f['montant'], 2, ',', ' ')?> €</td>
    <td class="aR"><?php echo number_format($f['montant_tva'], 2, ',', ' ')?> €</td>
    <td class="aR"><?php echo number_format($f['montant_tvac'], 2, ',', ' ')?> €</td>
  </tr>
<?php
//
$tt_htva+=$f['montant'];
$tt_tva+=$f['montant_tva'];
$tt_tvac+=$f['montant_tvac'];
//
$ta_htva+=$f['montant'];
$ta_tva+=$f['montant_tva'];
$ta_tvac+=$f['montant_tvac'];
//
$tg_htva+=$f['montant'];
$tg_tva+=$f['montant_tva'];
$tg_tvac+=$f['montant_tvac'];
//
if ($f['deductibilite']==1) {
	$tt_htva_d+=$f['montant'];
	$tt_tva_d+=$f['montant_tva'];
	$tt_tvac_d+=$f['montant_tvac'];
	$ta_htva_d+=$f['montant'];
	$ta_tva_d+=$f['montant_tva'];
	$ta_tvac_d+=$f['montant_tvac'];
	$tg_htva_d+=$f['montant'];
	$tg_tva_d+=$f['montant_tva'];
	$tg_tvac_d+=$f['montant_tvac'];
}
$counter++;
if($counter==$nombre){
?>
      <tr class="tot_trimestre">
        <th colspan="3">Total du trimestre <?php echo $key_trimestre ?></th>
<?php
/////// MISE EN DB DES TOTAUX (TABLE TRIMESTRE) //////////
$select_trimestre=mysql_query("SELECT * FROM trimestres WHERE annee='".substr($f['date'],0,4)."' AND trimestre='$key_trimestre' AND type=2") or trigger_error(mysql_error(),E_USER_ERROR);;
$totaux_trim=mysql_fetch_array($select_trimestre);
if($totaux_trim['id']){
  if($totaux_trim['montant_htva']!=$tt_htva){
    $id_trim=$totaux_trim['id'];
    $update_trimestre=mysql_query("UPDATE trimestres SET montant_htva='$tt_htva',montant_tva='$tt_tva',montant_tvac='$tt_tvac' WHERE id='$id_trim' AND type=2") or trigger_error(mysql_error(),E_USER_ERROR);;
  }
}else{
  $insert_trimestre=mysql_query("INSERT INTO trimestres (annee,trimestre,montant_htva,montant_tva,montant_tvac,type) VALUES ('".substr($f['date'],0,4)."','$key_trimestre','$tt_htva','$tt_tva','$tt_tvac',2)") or trigger_error(mysql_error(),E_USER_ERROR);;
}
//////////////////////////////////////////////////////////
?>
          <th class="aR"><?php echo number_format($tt_htva, 2, ',', ' ')?> €</th>
          <th class="aR"><?php echo number_format($tt_tva, 2, ',', ' ')?> €</th>
          <th class="aR"><?php echo number_format($tt_tvac, 2, ',', ' ')?> €</th>
        </tr>
<?php if ($tt_htva_d!=$tt_htva): ?>
      <tr class="tot_trimestre">
        <th colspan="3">Total du trimestre <?php echo $key_trimestre ?> (sans les factures non déductibles)</th>
          <th class="aR"><?php echo number_format($tt_htva_d, 2, ',', ' ')?> €</th>
          <th class="aR"><?php echo number_format($tt_tva_d, 2, ',', ' ')?> €</th>
          <th class="aR"><?php echo number_format($tt_tvac_d, 2, ',', ' ')?> €</th>
        </tr>  
<?php endif ?>
<?php if ($key_trimestre=="4" && !$ordre){ ?>
        <tr class="tot_annee">
          <th colspan="3">Total de l'année <?php echo substr($f['date'],0,4) ?></th>
          <th class="aR"><?php echo number_format($ta_htva, 2, ',', ' ')?> €</th>
          <th class="aR"><?php echo number_format($ta_tva, 2, ',', ' ')?> €</th>
          <th class="aR"><?php echo number_format($ta_tvac, 2, ',', ' ')?> €</th>
        </tr>
<?php
if ($annee=="all"): 
  $date_limite=date("Y");
else:
  $date_limite=$annee++;
endif
?>
<?php if (substr($f['date'],0,4) < $date_limite): ?>
      </table>
    </div>
    <div class="contenu">
      <h3><a href="facturesEntrantes.php?annee=<?php echo substr($f['date']+1,0,4) ?>"><?php echo substr($f['date']+1,0,4) ?></a></h3>
      <table>
    <?php endif ?>
<?php
unset($ta_htva,$ta_tva,$ta_tvac,$ta_htva_d,$ta_tva_d,$ta_tvac_d);
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
<?php
if ($annee=="all"):
?>
<div class="contenu">
  <table>
    <tr class="tot_general">
      <th style="width:66%" colspan="3">Total général</th>
      <th class="aR"><?php echo number_format($tg_htva, 2, ',', ' ')?> €</th>
      <th class="aR"><?php echo number_format($tg_tva, 2, ',', ' ')?> €</th>
      <th class="aR"><?php echo number_format($tg_tvac, 2, ',', ' ')?> €</th> 
    </tr>
  </table>
</div>
<?php
endif
?>
<?php $myInterface->get_footer(); ?>
