<?php
date_default_timezone_set('Europe/Brussels');

// vars pour les graphiques
$hauteur=500;
//

$hauteur=$hauteur-40;
include ('acces/cle.php');
include ('classes/interface.class.php');
$myInterface = new interface_();
if($_GET['annee']){
	$annee=$_GET['annee'];
}else{
	$annee=date("Y");
}
if($annee && $annee!="all"){
	$req=" AND annee='$annee'";
}
$select_trimestres=mysql_query("
	SELECT * FROM trimestres WHERE type=1".$req." ORDER BY annee, trimestre
	") or trigger_error(mysql_error(),E_USER_ERROR);
$select_trimestres_d=mysql_query("
	SELECT * FROM trimestres WHERE type=2".$req." ORDER BY annee, trimestre
	") or trigger_error(mysql_error(),E_USER_ERROR);
$select_max=mysql_query("
	SELECT montant_htva FROM trimestres ORDER BY montant_htva DESC LIMIT 1
	") or trigger_error(mysql_error(),E_USER_ERROR);
$max=mysql_fetch_array($select_max);
$max=$max['montant_htva'];
$nombre_trimestres=mysql_num_rows($select_trimestres);
if($nombre_trimestres>0){
  if($nombre_trimestres>1){
    $larg=floor(830/($nombre_trimestres-1));
  }else{
    $larg=830;
  }
$left_pos=45;
while($t = mysql_fetch_array($select_trimestres)){
  $x_pos[]=$left_pos;
  $y_pos[]=$hauteur-($t['montant_htva']*$hauteur/$max);
  $chiffres_in[]=$t['montant_htva'];
  $trimestre[]=$t['trimestre'];
  $lannee[]=$t['annee'];
  $left_pos+=$larg;
}
while($t_d = mysql_fetch_array($select_trimestres_d)){
  $y_pos_d[]=$hauteur-($t_d['montant_htva']*$hauteur/$max);
  $chiffres_out[]=$t_d['montant_htva'];
}
$x_pos=implode(',',$x_pos);
$y_pos=implode(',',$y_pos);
@$y_pos_d=implode(',',$y_pos_d);
$trimestre=implode(',',$trimestre);
$lannee=implode(',',$lannee);
$chiffres_in=implode(',',$chiffres_in);
@$chiffres_out=implode(',',$chiffres_out);

$myInterface->set_title("Factures sortantes");
$myInterface->get_header();
include ('include/menu.php');
?>
		<div style="width:900px;" class="contenu">
<?php 
include ('include/menu_annees.php');
include ('include/onglets.php');
?>
			<div style="margin-bottom:25px;border:1px solid #666">
  			<object data="stats_graph.php?hauteur=<?php echo $hauteur ?>&amp;lannee=<?php echo $lannee ?>&amp;trimestre=<?php echo $trimestre ?>&amp;larg=<?php echo $larg ?>&amp;max=<?php echo $max ?>&amp;x_pos=<? echo $x_pos?>&amp;chiffres_in=<? echo $chiffres_in?>&amp;chiffres_out=<? echo $chiffres_out?>&amp;max=<? echo $max?>" type="image/svg+xml" width="900" height="<?php echo $hauteur+40 ?>">
			</div>
			<div style="border:1px solid #666">
  			<object data="stats_graph2.php?hauteur=<?php echo $hauteur ?>&amp;lannee=<?php echo $lannee ?>&amp;trimestre=<?php echo $trimestre ?>&amp;larg=<?php echo $larg ?>&amp;max=<?php echo $max ?>&amp;x_pos=<? echo $x_pos?>&amp;chiffres_in=<? echo $chiffres_in?>&amp;chiffres_out=<? echo $chiffres_out?>" type="image/svg+xml" width="900" height="<?php echo $hauteur+40 ?>">
			</div>
		</div>
<?php } ?>
<?php $myInterface->get_footer(); ?>