<?php
if (isset($type) && !empty($type)) {
	$paramGetType = 'type='.$type.'&amp;';
} else {
	$paramGetType = '';
}
$select_annees = mysql_query("SELECT `date` FROM `facturesSortantes` ORDER BY `date` ASC") or trigger_error(mysql_error(),E_USER_ERROR);
?>
<?php
$une_annee_old = "";
while ($ann = mysql_fetch_array($select_annees)) {
  $une_annee = substr($ann['date'],0,4);
  if ($une_annee != $une_annee_old) {
    $les_annees[] = $une_annee;
  }
  $une_annee_old = $une_annee;
}
?>
<?php if (isset($les_annees) && is_array($les_annees)): ?>
        <ul id="liste_annees">
          <li id="recule">
<?php if($annee > $les_annees[0] && $annee != "all"){?>
            <a href="?<?php echo $paramGetType ?>annee=<?php echo $annee-1;?><?php if ($ordre):echo "&ordre=".$ordre;endif ?>">&lsaquo;</a>
<?php }else if($annee=="all"){?>
            <a href="?<?php echo $paramGetType ?>annee=<?php echo $les_annees[count($les_annees)-1];?><?php if ($ordre):echo "&ordre=".$ordre;endif ?>">&lsaquo;</a>
<?php }else{?>
            <a href="?<?php echo $paramGetType ?>annee=all<?php if ($ordre):echo "&ordre=".$ordre;endif ?>">&lsaquo;</a>
<?php } ?>
          </li>
          <li id="avance">
<?php if($annee < $les_annees[count($les_annees)-1] && $annee != "all"){?>
            <a href="?<?php echo $paramGetType ?>annee=<?php echo $annee+1;?><?php if ($ordre):echo "&ordre=".$ordre;endif ?>">&rsaquo;</a>
<?php }else if($annee=="all"){?>
            <a href="?<?php echo $paramGetType ?>annee=<?php echo $les_annees[0];?><?php if ($ordre):echo "&ordre=".$ordre;endif ?>">&rsaquo;</a>
<?php }else{?>
            <a href="?<?php echo $paramGetType ?>annee=all<?php if ($ordre):echo "&ordre=".$ordre;endif ?>">&rsaquo;</a>
<?php } ?>
          </li>
<?php
if ($annee == "all"){
  $actif = "class=\"actif\" ";
}else{
  $actif = "";
}
?>
          <li><a <?php echo $actif; ?>href="?<?php echo $paramGetType ?>annee=all">Toutes</a></li>
<?php foreach ($les_annees as $key) {?>
<?php
if ($key == $annee){
  $actif = "class=\"actif\" ";
}else{
  $actif = "";
}
?>
          <li><a <?php echo $actif; ?>href="?<?php echo $paramGetType ?>annee=<?php echo "$key" ?><?php if ($ordre): echo "&ordre=".$ordre;endif ?>"><?php echo $key;?></a></li>
<?php }
?>
        </ul>
<?php endif ?>
