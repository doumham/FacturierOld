<?php
include ('classes/interface.class.php');
$myInterface = new interface_();
$select_trimestres = mysql_query("SELECT * FROM trimestres WHERE type='sortantes' ORDER BY `annee`, `trimestre`") or trigger_error(mysql_error(),E_USER_ERROR);
$select_first_trimestres = mysql_query("SELECT * FROM trimestres WHERE type='sortantes' ORDER BY `annee`, `trimestre` LIMIT 1") or trigger_error(mysql_error(),E_USER_ERROR);
$select_trimestres_d = mysql_query("SELECT * FROM trimestres WHERE type='entrantes' ORDER BY `annee`, `trimestre`") or trigger_error(mysql_error(),E_USER_ERROR);
$first = mysql_fetch_array($select_first_trimestres);
$annees = date('Y') - ($first['annee'] + 0);
$ajout = 0;
if ($first['trimestre'] == '2') {
	$ajout = (365/4) * 24 * 60 * 60;
} else if($first['trimestre'] == '3') {
	$ajout = (365/2) * 24 * 60 * 60;
} else if($first['trimestre'] == '4') {
	$ajout = (365/4*3) * 24 * 60 * 60;
}
$nombre_trimestres = mysql_num_rows($select_trimestres);
$timeStart = time() - (($annees) * 365 * 24 * 60 * 60) + $ajout;
$timeStep = 365 / 4 * 24 * 60 * 60;
if($nombre_trimestres > 0){
	$counter = $timeStart;
	while($t = mysql_fetch_array($select_trimestres)){
		$datas[0][] = array('x'=>$counter, 'y'=>$t['montant_htva']+0);
		$trimestre[] = $t['trimestre'];
		$lannee[] = $t['annee'];
		$counter += $timeStep;
	}
	$datas[0][] = array('x'=>$counter, 'y'=>0);
	$counter2 = $timeStart;
	while($t_d = mysql_fetch_array($select_trimestres_d)){
		$datas[1][] = array('x'=>$counter2, 'y'=>$t_d['montant_htva']+0);
		$counter2 += $timeStep;
	}
	$datas[1][] = array('x'=>$counter2, 'y'=>0);
}
echo json_encode($datas);
?>
