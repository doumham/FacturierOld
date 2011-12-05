<?php
for ($i = 0; $i < count($chiffres_in); $i++) { 
	if (isset($chiffres_in[$i]) && isset($chiffres_out[$i])) {
		$y_pos_in_out[] = $hauteur - ( ($chiffres_in[$i] - $chiffres_out[$i]) * $hauteur / $max );
		$chiffres_in_out[] = $chiffres_in[$i] - $chiffres_out[$i];
	}
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
<?php 
	for ($i = 0; $i < $largeur ; $i += $larg) {
		// if (($i/$larg)%4 == 1) {
?>
		<line x1="<?php echo $i+45 ?>" y1="0" x2="<?php echo $i + 45 ?>" y2="<?php echo $hauteur + 20 ?>" stroke-dasharray="5" stroke-width=".2" />			 
<?php
		// }
	}
?>
	</g>
	<g stroke="black">
<!-- Légende abscisse (axe X)	-->
<?php 
for ($i = 0; $i < count($x_pos); $i++) {
	if ($trimestre[$i] == 1) {
?>
	<text fill="<?php echo $color ?>" transform="translate(<?php echo $x_pos[$i] ?>,<?php echo $hauteur + 35 ?>)" stroke="none" font-size="10" font-family="Verdana" ><?php echo $lannee[$i]; ?></text>
<?php 
	}
}
?>
<!-- Entrées -->
<?php
for ($i = 0; $i < count($y_pos); $i++) {
	if (isset($chiffres_in[$i])) {
		$chiffre_in = number_format($chiffres_in[$i], 2, ',', '');
		$chiffre_out = number_format($chiffres_out[$i], 2, ',', '');
		$chiffre_in_out = number_format($chiffres_in[$i] - $chiffres_out[$i], 2, ',', '');
		if (isset($x_pos[$i])) {
?>
			<rect x="<?php echo $x_pos[$i] ?>" y="<?php echo $y_pos[$i]+20  ?>" width="20" height="<?php echo $hauteur - $y_pos[$i] ?>" style="fill:rgb(150,100,50);stroke-width:0;stroke:rgb(0,0,0)"/>
			<rect x="<?php echo $x_pos[$i] ?>" y="<?php echo $y_pos_in_out[$i]+20  ?>" width="20" height="<?php echo $hauteur - $y_pos_in_out[$i] ?>" style="fill:rgb(130,180,30);stroke-width:0;stroke:rgb(0,0,0)"/>
<?php 		if ($y_pos_in_out[$i] - $y_pos[$i] > 40) {?>
			<text transform="translate(<?php echo $x_pos[$i]+13 ?>,<?php echo $y_pos_in_out[$i]+14 ?>) rotate(-90)" stroke="none" font-size="8" fill="rgba(0,0,0,.5)" font-family="Verdana" ><?php echo $chiffre_out?></text>
<?php			} ?>
<?php 		if ($hauteur - $y_pos_in_out[$i] > 40) {?>
			<text transform="translate(<?php echo $x_pos[$i]+13 ?>,<?php echo $hauteur+14 ?>) rotate(-90)" stroke="none" font-size="8" fill="rgba(0,0,0,.5)" font-family="Verdana" ><?php echo $chiffre_in_out?></text>
<?php			} ?>
			<text transform="translate(<?php echo $x_pos[$i]-8 ?>,<?php echo $y_pos[$i]+14 ?>)" stroke="none" font-size="8" fill="rgba(0,0,0,.8)" font-family="Verdana" ><?php echo $chiffre_in ?></text>
<?php
		}
	}
}
?>
	</g>
</svg>