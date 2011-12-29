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
// $time = strtotime('01-01-2004');
$time = time() - $annees * 365 * 24 * 60 * 60 + $ajout;
$timeStep = 365 / 4 * 24 * 60 * 60; // Un trimestre en secondes

// Premier graphique
if($nombre_trimestres > 0){
	while($t = mysql_fetch_array($select_trimestres)){
		$chiffres_in[] = $t['montant_htva'];
	}
	while($t_d = mysql_fetch_array($select_trimestres_d)){
		$chiffres_out[] = $t_d['montant_htva'];
	}
}
for ($i = 0; $i < count($chiffres_in); $i++) { 
	if (isset($chiffres_in[$i]) && isset($chiffres_out[$i])) {
		$datas[0][] = array('x'=>$time, 'y'=>$chiffres_in[$i]-$chiffres_out[$i]+0);
		$datas[1][] = array('x'=>$time, 'y'=>($chiffres_out[$i]+0));
		$time += $timeStep;
	}
}
$datas[0][] = array('x'=>$time, 'y'=>0);
$datas[1][] = array('x'=>$time, 'y'=>0);

$time = time() - $annees * 365 * 24 * 60 * 60 + $ajout;
// Deuxième graphique
$chiffres_in_tmp = $chiffres_in;
if (isset($chiffres_out)) {
	$chiffres_out_tmp = $chiffres_out;
}
$total_in = 0;
$total_out = 0;
foreach ($chiffres_in_tmp as $chiffreInTmp) {
	$total_in += $chiffreInTmp;
	$datas[2][] = array('x'=>$time, 'y'=>$total_in+0);
	$time += $timeStep;
}
$time = time() - $annees * 365 * 24 * 60 * 60 + $ajout;
if (isset($chiffres_out) && isset($chiffres_out_tmp)) {
	foreach ($chiffres_out_tmp as $chiffreOutTmp) {
		$total_out += $chiffreOutTmp;
		$datas[3][] = array('x'=>$time, 'y'=>$total_out+0);
		$time += $timeStep;
	}
}
// $datas[2][] = array('x'=>$time, 'y'=>0);
// $datas[3][] = array('x'=>$time, 'y'=>0);

echo json_encode($datas);
?>
