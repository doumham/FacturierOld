<?php
if (isset($type) && !empty($type)) {
	$paramGetType = 'type='.$type.'&amp;';
} else {
	$paramGetType = '';
}
$selectAnneeMin = mysql_query("SELECT `date` FROM `facturesSortantes` ORDER BY `date` ASC LIMIT 1") or trigger_error(mysql_error(),E_USER_ERROR);
$selectAnneeMax = mysql_query("SELECT `date` FROM `facturesSortantes` ORDER BY `date` DESC LIMIT 1") or trigger_error(mysql_error(),E_USER_ERROR);
$anneeMinFetched = mysql_fetch_array($selectAnneeMin);
$anneeMaxFetched = mysql_fetch_array($selectAnneeMax);
$anneeMin = substr($anneeMinFetched['date'],0,4);
$anneeMax = substr($anneeMaxFetched['date'],0,4);
if ($anneeMax < date('Y')) {
	$anneeMax++;
}
while ($anneeMin <= $anneeMax) {
	$les_annees[] = $anneeMin;
	$anneeMin++;
}
?>
<?php if (isset($les_annees) && is_array($les_annees)): ?>
        <ul id="liste_annees">
          <li id="recule">
<?php if($annee > $les_annees[0] && $annee != "all"){?>
            <a href="?<?php echo $paramGetType ?>annee=<?php echo $annee-1;?><?php if ($ordre):echo "&ordre=".$ordre;endif ?>#bottom">&lsaquo;</a>
<?php }else if($annee=="all"){?>
            <a href="?<?php echo $paramGetType ?>annee=<?php echo $les_annees[count($les_annees)-1];?><?php if ($ordre):echo "&ordre=".$ordre;endif ?>#bottom">&lsaquo;</a>
<?php }else{?>
            <a href="?<?php echo $paramGetType ?>annee=all<?php if ($ordre):echo "&ordre=".$ordre;endif ?>#bottom">&lsaquo;</a>
<?php } ?>
          </li>
          <li id="avance">
<?php if($annee < $les_annees[count($les_annees)-1] && $annee != "all"){?>
            <a href="?<?php echo $paramGetType ?>annee=<?php echo $annee+1;?><?php if ($ordre):echo "&ordre=".$ordre;endif ?>#bottom">&rsaquo;</a>
<?php }else if($annee=="all"){?>
            <a href="?<?php echo $paramGetType ?>annee=<?php echo $les_annees[0];?><?php if ($ordre):echo "&ordre=".$ordre;endif ?>#bottom">&rsaquo;</a>
<?php }else{?>
            <a href="?<?php echo $paramGetType ?>annee=all<?php if ($ordre):echo "&ordre=".$ordre;endif ?>#bottom">&rsaquo;</a>
<?php } ?>
          </li>
<?php
if ($annee == "all"){
  $actif = "class=\"actif\" ";
}else{
  $actif = "";
}
?>
          <li><a <?php echo $actif; ?>href="?<?php echo $paramGetType ?>annee=all#bottom">Toutes</a></li>
<?php foreach ($les_annees as $key) {?>
<?php
if ($key == $annee){
  $actif = "class=\"actif\" ";
}else{
  $actif = "";
}
?>
          <li><a <?php echo $actif; ?>href="?<?php echo $paramGetType ?>annee=<?php echo "$key" ?><?php if ($ordre): echo "&ordre=".$ordre;endif ?>#bottom"><?php echo $key;?></a></li>
<?php }
?>
        </ul>
<?php endif ?>
