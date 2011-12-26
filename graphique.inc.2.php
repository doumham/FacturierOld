<?php
$chiffres_in_tmp = $chiffres_in;
if (isset($chiffres_out)) {
	$chiffres_out_tmp = $chiffres_out;
}
$chiffres_in = array();
$chiffres_out = array();
$chiffres_in_out = array();
$y_pos = array();
$y_pos_d = array();
$y_pos_in_out = array();
$total_in = 0;
$total_out = 0;
foreach ($chiffres_in_tmp as $chiffreInTmp) {
	$total_in += $chiffreInTmp;
	$chiffres_in[] = $total_in;
}
foreach ($chiffres_in as $chiffreIn) {
	$y_pos[] = floor($hauteur - ($chiffreIn * $hauteur / $total_in));
}
if (isset($chiffres_out) && isset($chiffres_out_tmp)) {
	foreach ($chiffres_out_tmp as $chiffreOutTmp) {
		$total_out += $chiffreOutTmp;
		$chiffres_out[] = $total_out;
	}
	foreach ($chiffres_out as $chiffreOut) {
		$y_pos_d[] = floor($hauteur-($chiffreOut * $hauteur / $total_in));
	}
}
if (isset($chiffres_in)) {
	for ($i=0; $i < count($chiffres_in); $i++) { 
		if (isset($chiffres_out[$i])) {
			$y_pos_in_out[] = floor($hauteur-( ($chiffres_in[$i]-$chiffres_out[$i])*$hauteur/$total_in) );
			$chiffres_in_out[] = $chiffres_in[$i]-$chiffres_out[$i];
		}
	}
}
?>
<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 0 0" preserveAspectRatio="xMidYMid slice" style="min-width:<?php echo $largeur+100 ?>px; width:100%; height:<?php echo $hauteur+40 ?>px; position:absolute; top:<?php echo $hauteur+250 ?>px; left:0;">
	<g stroke="grey">
		<?php $rapport = $hauteur / $total_in ?>
<!-- lignes horizontales	-->
<?php 
$graduations = 0;
$increment = 10000;
for ($i = $hauteur; $i >= -40 ; $i = $i - $rapport * $increment) { ?>
	<line x1="0" y1="<?php echo $i+20 ?>" x2="<?php echo $largeur+100 ?>" y2="<?php echo $i+20 ?>" stroke-width=".2" />			 
	<text fill="#ccc" transform="translate(5,<?php echo $i+17 ?>)" stroke="none" font-size="10" font-family="Verdana" ><?php echo $graduations ?></text>
	<?php $graduations += $increment;
} ?>
<!-- lignes verticales	-->
<?php 
	for ($i = 0; $i < $largeur ; $i += $larg) {
?>
		<line x1="<?php echo $i+45 ?>" y1="0" x2="<?php echo $i + 45 ?>" y2="<?php echo $hauteur + 20 ?>" stroke-dasharray="5" stroke-width=".2" stroke="#000" />			 
<?php
	}
?>
	</g>
	<g stroke="black">
<!-- Légende abscisse (axe X)	-->
<?php 
for ($i = 0; $i < count($x_pos); $i++) {
	if ($trimestre[$i] == 1) {
?>
	<text transform="translate(<?php echo $x_pos[$i]-10 ?>,<?php echo $hauteur + 35 ?>)" stroke="none" font-size="10" font-family="Verdana" ><?php echo $lannee[$i]; ?></text>
<?php 
	}
}
?>
<!-- IN -->
		<?php for ($i = 0; $i < count($y_pos); $i++): ?>
			<?php if (isset($chiffres_in[$i])): ?>
			<?php $chiffre_in = number_format($chiffres_in[$i], 2, ',', ' ')." €" ?>
			<?php if (isset($x_pos[$i+1]) && $x_pos[$i+1]): ?>
				<line x1="<?php echo $x_pos[$i] ?>" y1="<?php echo $y_pos[$i]+20 ?>" x2="<?php echo $x_pos[$i+1] ?>" y2="<?php echo $y_pos[$i+1]+20 ?>" stroke="#666" stroke-width="1" />
			<?php endif ?>
			<circle cx="<?php echo $x_pos[$i] ?>" cy="<?php echo $y_pos[$i]+20 ?>" r="2" fill="#666" stroke="none" stroke-width="1" />
			<rect x="<?php echo $x_pos[$i]-34 ?>" y="<?php echo $y_pos[$i]+28 ?>" width="<?php taille_de_vignette($chiffre_in) ?>" height="13" fill="#fff" stroke="#999" />
			<text transform="translate(<?php echo $x_pos[$i]-31 ?>,<?php echo $y_pos[$i]+38 ?>)" fill="#666" stroke="none" font-size="10" font-family="Verdana" ><?php echo $chiffre_in?></text>
		<?php endif ?>
		<?php endfor ?>
<!-- OUT -->
		<?php for ($i=0; $i < count($y_pos_d); $i++): ?>
			<?php if (isset($chiffres_out[$i])): ?>
			<?php $chiffre_out = number_format($chiffres_out[$i], 2, ',', ' ')." €" ?>
			<?php if (isset($y_pos_d[$i+1]) && $y_pos_d[$i+1] != 0): ?> 
				<line x1="<?php echo $x_pos[$i] ?>" y1="<?php echo $y_pos_d[$i]+20 ?>" x2="<?php echo $x_pos[$i+1] ?>" y2="<?php echo $y_pos_d[$i+1]+20 ?>" stroke="#ccc" stroke-width="1" />
			<?php endif ?>
			<circle cx="<?php echo $x_pos[$i] ?>" cy="<?php echo $y_pos_d[$i]+20 ?>" r="2" fill="#ccc" stroke="none" stroke-width="1" />
			<rect x="<?php echo $x_pos[$i]-34 ?>" y="<?php echo $y_pos_d[$i]+28 ?>" width="<?php taille_de_vignette($chiffre_out) ?>" height="13" fill="white" stroke="#ccc" stroke-width="1"/>
			<text transform="translate(<?php echo $x_pos[$i]-31 ?>,<?php echo $y_pos_d[$i]+38 ?>)" fill="#666" stroke="none" font-size="10" font-family="Verdana" ><?php echo $chiffre_out?></text>
		<?php endif ?>
		<?php endfor ?>
<!-- IN MOINS OUT -->
		<?php for ($i=0; $i < count($y_pos_in_out); $i++): ?>
			<?php if (isset($chiffres_in_out[$i])): ?>
			<?php $chiffre_in_out=number_format($chiffres_in_out[$i], 2, ',', ' ')." €" ?>
			<?php if (isset($y_pos_in_out[$i+1]) && $y_pos_in_out[$i+1] != 0): ?> 
				<line x1="<?php echo $x_pos[$i] ?>" y1="<?php echo $y_pos_in_out[$i]+20 ?>" x2="<?php echo $x_pos[$i+1] ?>" y2="<?php echo $y_pos_in_out[$i+1]+20 ?>" stroke-width="1" />
			<?php endif ?>
			<circle cx="<?php echo $x_pos[$i] ?>" cy="<?php echo $y_pos_in_out[$i]+20 ?>" r="2" fill="#000" stroke="none" stroke-width="1" />
			<rect x="<?php echo $x_pos[$i]-34 ?>" y="<?php echo $y_pos_in_out[$i]+28 ?>" width="<?php taille_de_vignette($chiffre_in_out) ?>" height="13" fill="white" stroke="#666" stroke-width="1"/>
			<text transform="translate(<?php echo $x_pos[$i]-31 ?>,<?php echo $y_pos_in_out[$i]+38 ?>)" stroke="none" font-size="10" font-family="Verdana" ><?php echo $chiffre_in_out?></text>
		<?php endif ?>
		<?php endfor ?>
	</g>
</svg>
