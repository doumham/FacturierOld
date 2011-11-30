<?php
foreach ($chiffres_in as $chiffreIn) {
	$y_pos[] = $hauteur-($chiffreIn * $hauteur / $max);
}
foreach ($chiffres_out as $chiffreOut) {
	$y_pos_d[] = $hauteur - ($chiffreOut * $hauteur / $max);
}
for ($i = 0; $i < count($chiffres_in); $i++) { 
	$y_pos_in_out[] = $hauteur-( ($chiffres_in[$i] - $chiffres_out[$i])*$hauteur/$max );
	$chiffres_in_out[] = $chiffres_in[$i] - $chiffres_out[$i];
}
?>
<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 0 0" preserveAspectRatio="xMidYMid slice" style="border:1px solid #333; width:<?php echo $largeur+100 ?>px; height:<?php echo $hauteur+40 ?>px; position:absolute; top:166px; left:0;">
	<g stroke="grey">
		<?php $rapport = $hauteur / $max ?>
<!-- lignes horizontales	-->
<?php $graduations = 0;
for ($i = $hauteur; $i >= -40; $i = $i - $rapport * 1000) { ?>
			<line x1="0" y1="<?php echo $i + 20 ?>" x2="<?php echo $largeur+100 ?>" y2="<?php echo $i + 20 ?>" stroke-width=".2" />			 
			<text fill="#ccc" transform="translate(5,<?php echo $i+17 ?>)" stroke="none" font-size="10" font-family="Verdana" ><?php echo $graduations ?></text>
		<?php $graduations += 1000;} ?>
<!-- lignes verticales	-->
<?php for ($i = 0; $i < $largeur ; $i += $larg) {?>
			<line x1="<?php echo $i+45 ?>" y1="0" x2="<?php echo $i + 45 ?>" y2="<?php echo $hauteur + 20 ?>" stroke-dasharray="10" stroke-width=".2" />			 
<?php } ?>
	</g>
	<g stroke="black">
<!-- Légende abscisse (axe X)	-->
<?php 
for ($i = 0; $i < count($x_pos); $i++) {
	if ($trimestre[$i] == 1) {
		$color = '#333';
	} else {
		$color = '#999';
	}
?>
		<text fill="<?php echo $color ?>" transform="translate(<?php echo $x_pos[$i] ?>,<?php echo $hauteur + 35 ?>)" stroke="none" font-size="10" font-family="Verdana" ><?php echo $trimestre[$i]; ?></text>
<?php 
} 
?>
<!-- Entrées -->
<?php
for ($i = 0; $i < count($y_pos); $i++) {
	if (isset($chiffres_in[$i])) {
		$chiffre_in = number_format($chiffres_in[$i], 2, ',', ' ')." €";
			if (isset($x_pos[$i + 1])) {
?>
			<line x1="<?php echo $x_pos[$i] ?>" y1="<?php echo $y_pos[$i] + 20 ?>" x2="<?php echo $x_pos[$i + 1] ?>" y2="<?php echo $y_pos[$i + 1] + 20 ?>" stroke="#666" stroke-width="1" />			 
<?php
		}
?>
			<circle cx="<?php echo $x_pos[$i] ?>" cy="<?php echo $y_pos[$i] + 20 ?>" r="2" fill="#999" stroke="none" stroke-width="1" />
			<rect x="<?php echo $x_pos[$i] - 34 ?>" y="<?php echo $y_pos[$i] + 2 ?>" width="<?php taille_de_vignette($chiffre_in) ?>" height="13" fill="#fff" stroke="#999" stroke-width="1" />
			<text transform="translate(<?php echo $x_pos[$i]-31 ?>,<?php echo $y_pos[$i]+12 ?>)" fill="#666" stroke="none" font-size="10" font-family="Verdana" ><?php echo $chiffre_in?></text>
<?php
	}
}
?>
<!-- Sorties -->
<?php
for ($i = 0; $i < count($y_pos_d); $i++) {
	if (isset($chiffres_in[$i])) {
		$chiffre_out = number_format($chiffres_out[$i], 2, ',', ' ')." €";
		if ($y_pos_d[$i + 1] != 0) {
?> 
			<line x1="<?php echo $x_pos[$i] ?>" y1="<?php echo $y_pos_d[$i] + 20 ?>" x2="<?php echo $x_pos[$i + 1] ?>" y2="<?php echo $y_pos_d[$i + 1] + 20 ?>" stroke="#ccc" stroke-width="1" />			 
<?php 	} ?>
			<circle cx="<?php echo $x_pos[$i] ?>" cy="<?php echo $y_pos_d[$i] + 20 ?>" r="2" fill="#ccc" stroke="none" stroke-width="1" />
			<rect x="<?php echo $x_pos[$i] - 34 ?>" y="<?php echo $y_pos_d[$i] + 28 ?>" width="<?php taille_de_vignette($chiffre_out) ?>" height="13" fill="white" stroke="#ccc" stroke-width="1" />
			<text transform="translate(<?php echo $x_pos[$i] - 31 ?>,<?php echo $y_pos_d[$i] + 38 ?>)" stroke="none" font-size="10" fill="#999" font-family="Verdana" ><?php echo $chiffre_out?></text>
<?php
	}
}
?>
<!-- Entrées moins sorties -->
<?php 
for ($i = 0; $i < count($y_pos_in_out); $i++) {
	if (isset($chiffres_in[$i]) && isset($chiffres_out[$i])) {
		$chiffre_in_out = number_format($chiffres_in[$i] - $chiffres_out[$i], 2, ',', ' ')." €";
		if (isset($y_pos_in_out[$i+1]) && $y_pos_in_out[$i+1] != 0) { ?> 
		<line x1="<?php echo $x_pos[$i] ?>" y1="<?php echo $y_pos_in_out[$i] + 20 ?>" x2="<?php echo $x_pos[$i + 1] ?>" y2="<?php echo $y_pos_in_out[$i + 1] + 20 ?>" stroke="#333" stroke-width="1" />			 
<?php
		}
?>
	<circle cx="<?php echo $x_pos[$i] ?>" cy="<?php echo $y_pos_in_out[$i] + 20 ?>" r="2" fill="#000" stroke="none" stroke-width="1" />
	<rect x="<?php echo $x_pos[$i] - 34 ?>" y="<?php echo $y_pos_in_out[$i] + 28 ?>" width="<?php taille_de_vignette($chiffre_in_out) ?>" height="13" fill="white" stroke="#333" stroke-width="1" />
	<text transform="translate(<?php echo $x_pos[$i]-31 ?>,<?php echo $y_pos_in_out[$i] + 38 ?>)" stroke="none" font-size="10" fill="#000" font-family="Verdana" ><?php echo $chiffre_in_out?></text>
<?php
	}
}
?>
	</g>
</svg>