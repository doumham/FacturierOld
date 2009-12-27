<?php
include ('classes/interface.class.php');
$myInterface = new interface_();

$tt_htva_1   = 0;
$tt_tva_1    = 0;
$tt_tvac_1   = 0;
$tt_htva_2   = 0;
$tt_tva_2    = 0;
$tt_tvac_2   = 0;
$tt_htva_3   = 0;
$tt_tva_3    = 0;
$tt_tvac_3   = 0;
$tt_htva_4   = 0;
$tt_tva_4    = 0;
$tt_tvac_4   = 0;
$t_htva      = 0;
$t_tva       = 0;
$t_tvac      = 0;
$tt_htva_d_1 = 0;
$tt_tva_d_1  = 0;
$tt_tvac_d_1 = 0;
$tt_htva_d_2 = 0;
$tt_tva_d_2  = 0;
$tt_tvac_d_2 = 0;
$tt_htva_d_3 = 0;
$tt_tva_d_3  = 0;
$tt_tvac_d_3 = 0;
$tt_htva_d_4 = 0;
$tt_tva_d_4  = 0;
$tt_tvac_d_4 = 0;
$t_htva_d    = 0;
$t_tva_d     = 0;
$t_tvac_d    = 0;
$tts_htva_1  = 0;
$tts_htva_2  = 0;
$tts_htva_3  = 0;
$tts_htva_4  = 0;
$tts_tva_1   = 0;
$tts_tva_2   = 0;
$tts_tva_3   = 0;
$tts_tva_4   = 0;
$tts_tvac_1  = 0;
$tts_tvac_2  = 0;
$tts_tvac_3  = 0;
$tts_tvac_4  = 0;
$ts_htva     = 0;
$ts_tva      = 0;
$ts_tvac     = 0;
$ordre       = 0;

if(isset($_GET['annee']) && !empty($_GET['annee'])){
	$annee = $_GET['annee'];
}else{
	$annee = date("Y");
}
if($annee && $annee!="all"){
  $date1 = $annee."-00-00";
  $date2 = $annee+1;
  $date2 = $date2."-00-00";
	$req = "WHERE date>'$date1' AND date<'$date2'";
} else {
	$req = '';
}
if(isset($_GET['ordre']) && !empty($_GET['ordre'])){
	$ordre = $_GET['ordre'];
	$req2 = "facturesSortantes.id_client,";
} else {
	$req2 = '';
}
$selectFacturesSortantes = mysql_query("SELECT * FROM facturesSortantes ".$req." ORDER BY ".$req2." date") or trigger_error(mysql_error(),E_USER_ERROR);
$nombreFacturesSortantes = mysql_num_rows($selectFacturesSortantes);
$selectFacturesEntrantes = mysql_query("SELECT * FROM facturesEntrantes ".$req." ORDER BY ".$req2." date") or trigger_error(mysql_error(),E_USER_ERROR);
?>
<?php 
$myInterface->set_title("Statistiques");
$myInterface->get_header();
include('include/header.php');
?>
		<div class="contenu" style=" margin-top:146px;">
<?php 
include('include/menu_annees.php');
include('include/onglets.php');
?>
    <table id="resume"> 
      <tr class="legende">
        <th>Trimestre</th>
        <th class="aR">Montant HTVA</th>
        <th class="aR">Montant TVA</th>
        <th class="aR">Total TVAC</th>
      </tr>
<?php
while($f = mysql_fetch_array($selectFacturesSortantes)){
	if($f['date'] < $annee."-04-00"){
		$tt_htva_1 += $f['montant'];
		$tt_tva_1 += $f['montant_tva'];
		$tt_tvac_1 += $f['montant_tvac'];
	}
	if($f['date'] < $annee."-07-00" && $f['date']>$annee."-04-00"){
		$tt_htva_2 += $f['montant'];
		$tt_tva_2 += $f['montant_tva'];
		$tt_tvac_2 += $f['montant_tvac'];
	}
	if($f['date'] < $annee."-10-00" && $f['date']>$annee."-07-00"){
		$tt_htva_3 += $f['montant'];
		$tt_tva_3 += $f['montant_tva'];
		$tt_tvac_3 += $f['montant_tvac'];
	}
	if($f['date'] <= $annee."-12-31" && $f['date']>$annee."-10-00"){
		$tt_htva_4 += $f['montant'];
		$tt_tva_4 += $f['montant_tva'];
		$tt_tvac_4 += $f['montant_tvac'];
	}
	$t_htva += $f['montant'];
	$t_tva += $f['montant_tva'];
	$t_tvac += $f['montant_tvac'];
}
while($f = mysql_fetch_array($selectFacturesEntrantes)){
	if($f['date'] < $annee."-04-00"){
		$tt_htva_d_1 += $f['montant'];
		$tt_tva_d_1 += $f['montant_tva'];
		$tt_tvac_d_1 += $f['montant_tvac'];
	}
	if($f['date'] < $annee."-07-00" && $f['date']>$annee."-04-00"){
		$tt_htva_d_2 += $f['montant'];
		$tt_tva_d_2 += $f['montant_tva'];
		$tt_tvac_d_2 += $f['montant_tvac'];
	}
	if($f['date'] < $annee."-10-00" && $f['date']>$annee."-07-00"){
		$tt_htva_d_3 += $f['montant'];
		$tt_tva_d_3 += $f['montant_tva'];
		$tt_tvac_d_3 += $f['montant_tvac'];
	}
	if($f['date'] <= $annee."-12-31" && $f['date']>$annee."-10-00"){
		$tt_htva_d_4 += $f['montant'];
		$tt_tva_d_4 += $f['montant_tva'];
		$tt_tvac_d_4 += $f['montant_tvac'];
	}
	$t_htva_d += $f['montant'];
	$t_tva_d += $f['montant_tva'];
	$t_tvac_d += $f['montant_tvac'];
}
$tts_htva_1 = $tt_htva_1-$tt_htva_d_1;
$tts_htva_2 = $tt_htva_2-$tt_htva_d_2;
$tts_htva_3 = $tt_htva_3-$tt_htva_d_3;
$tts_htva_4 = $tt_htva_4-$tt_htva_d_4;
$tts_tva_1 = $tt_tva_1-$tt_tva_d_1;
$tts_tva_2 = $tt_tva_2-$tt_tva_d_2;
$tts_tva_3 = $tt_tva_3-$tt_tva_d_3;
$tts_tva_4 = $tt_tva_4-$tt_tva_d_4;
$tts_tvac_1 = $tt_tvac_1-$tt_tvac_d_1;
$tts_tvac_2 = $tt_tvac_2-$tt_tvac_d_2;
$tts_tvac_3 = $tt_tvac_3-$tt_tvac_d_3;
$tts_tvac_4 = $tt_tvac_4-$tt_tvac_d_4;
$ts_htva = $t_htva-$t_htva_d;
$ts_tva = $t_tva-$t_tva_d;
$ts_tvac = $t_tvac-$t_tvac_d;
for ($i=1; $i < 5 ; $i++) { 
?>
<tr class="facture" style="border:none; background:#fefefe;">
	<td>Trimestre <?php echo $i ?></td>
	<td class="aR">
		<em>Cadre 03</em> <?php echo number_format(${"tt_htva_".$i}, 2, ',', ' ')?> €<br />
	</td>
	<td class="aR">
		<em>Cadre 54</em> <?php echo number_format(${"tt_tva_".$i}, 2, ',', ' ')?> €<br />
	</td>
	<td class="aR">
		<?php echo number_format(${"tt_tvac_".$i}, 2, ',', ' ')?> €<br />
	</td> 
</tr>
<tr class="facture" style="border:none; background:#fefefe;">
	<td></td>
	<td class="aR">
		<em>Cadre 82</em> <?php echo number_format(${"tt_htva_d_".$i}, 2, ',', ' ')?> €<br />
	</td>
	<td class="aR">
		<em>Cadre 59</em> <?php echo number_format(${"tt_tva_d_".$i}, 2, ',', ' ')?> €<br />
	</td>
	<td class="aR">
		<?php echo number_format(${"tt_tvac_d_".$i}, 2, ',', ' ')?> €<br />
	</td> 
</tr>
<tr class="facture" style="background:#fefefe;">
	<td></td>
	<td class="aR">
		<?php echo number_format(${"tts_htva_".$i}, 2, ',', ' ')?> €
	</td>
	<td class="aR">
		<em>Cadre 71</em> <?php echo number_format(${"tts_tva_".$i}, 2, ',', ' ')?> €
	</td>
	<td class="aR">
		<?php echo number_format(${"tts_tvac_".$i}, 2, ',', ' ')?> €
	</td> 
</tr>
<?php } ?>
      <tr class="tot_annee" style="background:#fefefe;">
        <th></th>
        <th class="aR">
			<?php echo number_format($t_htva, 2, ',', ' ')?> €<br />
			<?php echo number_format($t_htva_d, 2, ',', ' ')?> €<br />
			<?php echo number_format($ts_htva, 2, ',', ' ')?> €
		</th>
        <th class="aR">
			<?php echo number_format($t_tva, 2, ',', ' ')?> €<br />
			<?php echo number_format($t_tva_d, 2, ',', ' ')?> €<br />
			<?php echo number_format($ts_tva, 2, ',', ' ')?> €
		</th>
        <th class="aR">
			<?php echo number_format($t_tvac, 2, ',', ' ')?> €<br />
			<?php echo number_format($t_tvac_d, 2, ',', ' ')?> €<br />
			<?php echo number_format($ts_tvac, 2, ',', ' ')?> €
		</th>
     </tr>
    </table>
</div>
<?php $myInterface->get_footer(); ?>