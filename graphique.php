<?php
include ('classes/interface.class.php');
$myInterface = new interface_();
$myInterface->set_title("Facturier – Graphique");
$myInterface->get_header();
include ('include/onglets.php');
$hauteur = 600;
$largeur = 980;
$hauteur = $hauteur-40;
$ordre = 0;
function taille_de_vignette($string){
	$taille = mb_strlen($string);
	echo $taille * 5.5 + 5;
}
if(isset($_GET['annee']) && !empty($_GET['annee'])){
	$annee = $_GET['annee'];
} else {
	$annee="all";
}
$select_trimestres = mysql_query("SELECT * FROM trimestres WHERE type='sortantes' ORDER BY `annee`, `trimestre`") or trigger_error(mysql_error(),E_USER_ERROR);
$select_trimestres_d = mysql_query("SELECT * FROM trimestres WHERE type='entrantes' ORDER BY `annee`, `trimestre`") or trigger_error(mysql_error(),E_USER_ERROR);
$select_max = mysql_query("SELECT montant_htva FROM trimestres ORDER BY montant_htva DESC LIMIT 1") or trigger_error(mysql_error(),E_USER_ERROR);
$max = mysql_fetch_array($select_max);
$max = $max['montant_htva'];
$nombre_trimestres = mysql_num_rows($select_trimestres);
if($nombre_trimestres > 0){
	if($nombre_trimestres > 1){
		$larg = floor($largeur/($nombre_trimestres-1));
	} else {
		$larg = $largeur;
	}
	$left_pos = 45;
	while($t = mysql_fetch_array($select_trimestres)){
		$x_pos[] = $left_pos;
		$y_pos[] = floor($hauteur - ($t['montant_htva'] * $hauteur / $max));
		$chiffres_in[] = $t['montant_htva'];
		$trimestre[] = $t['trimestre'];
		$lannee[] = $t['annee'];
		$left_pos += $larg;
	}
	while($t_d = mysql_fetch_array($select_trimestres_d)){
		$y_pos_d[] = floor($hauteur - ($t_d['montant_htva'] * $hauteur / $max));
		$chiffres_out[] = $t_d['montant_htva'];
	}

	include('graphique.inc.1.php');
	include('graphique.inc.2.php');
}

$myInterface->get_footer();
?>