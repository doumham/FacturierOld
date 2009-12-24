<?php
mb_internal_encoding("UTF-8");
header('Content-Type: image/svg+xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="no"?>';
$x_pos = explode(",",$_GET['x_pos']);
$lannee = explode(",",$_GET['lannee']);
$trimestre = explode(",",$_GET['trimestre']);
$chiffres_in_tmp = explode(",",$_GET['chiffres_in']);
$chiffres_out_tmp = explode(",",$_GET['chiffres_out']);
$hauteur = $_GET['hauteur'];
foreach ($chiffres_in_tmp as $value) {
  $total_in += $value;
  $chiffres_in[] = $total_in;
}
foreach ($chiffres_in as $value) {
  $y_pos[] = $hauteur-($value*$hauteur/$total_in);
}
foreach ($chiffres_out_tmp as $value_d) {
  $total_out += $value_d;
  $chiffres_out[] = $total_out;
}
foreach ($chiffres_out as $value_d) {
  $y_pos_d[] = $hauteur-($value_d*$hauteur/$total_in);
}
for ($i=0; $i < count($chiffres_in); $i++) { 
  $y_pos_in_out[] = $hauteur-( ($chiffres_in[$i]-$chiffres_out[$i])*$hauteur/$total_in );
  $chiffres_in_out[] = $chiffres_in[$i]-$chiffres_out[$i];
}
function taille_de_vignette($string){
  $taille = mb_strlen($string);
  echo $taille*5.5+5;
}
?>
<svg width="900px" height="<?php echo $hauteur+40 ?>px" version="1.0" xmlns="http://www.w3.org/2000/svg">
  <g stroke="grey">
    <?php $rapport = $hauteur/$total_in ?>
<!--  lignes horizontales  -->
<?php $graduations = 0; ?>
        <?php for ($i=$hauteur; $i >= -40 ; $i=$i-$rapport*5000) {?>
      <line x1="0" y1="<?php echo $i+20 ?>" x2="900" y2="<?php echo $i+20 ?>" stroke-width=".2" />       
      <text fill="#ccc" transform="translate(5,<?php echo $i+17 ?>)" stroke="none" font-size="10" font-family="Verdana" ><?php echo $graduations ?></text>
    <?php $graduations+=5000;} ?>
<!--  lignes verticales  -->
<?php for ($i=0; $i < 900 ; $i+=$_GET['larg']) {?>
        <line x1="<?php echo $i+45 ?>" y1="0" x2="<?php echo $i+45 ?>" y2="<?php echo $hauteur+20 ?>" stroke-dasharray="10" stroke-width=".2" />       
<?php } ?>
  </g>
  <g stroke="black">
<!-- Légende abscisse (axe X)  -->
    <?php for ($i=0; $i < count($x_pos); $i++): ?>
      <text fill="#999" transform="translate(<?php echo $x_pos[$i]-15 ?>,<?php echo $hauteur+35 ?>)" stroke="none" font-size="10" font-family="Verdana" ><?php echo $trimestre[$i]."/".$lannee[$i]; ?></text>
    <?php endfor ?>
<!-- IN -->
    <?php for ($i=0; $i < count($y_pos); $i++): ?>
      <?php $chiffre_in=number_format($chiffres_in[$i], 2, ',', ' ')." €" ?>
      <?php if ($x_pos[$i+1]): ?>
        <line x1="<?php echo $x_pos[$i] ?>" y1="<?php echo $y_pos[$i]+20 ?>" x2="<?php echo $x_pos[$i+1] ?>" y2="<?php echo $y_pos[$i+1]+20 ?>" stroke="#666" stroke-width="1" />
      <?php endif ?>
      <circle cx="<?php echo $x_pos[$i] ?>" cy="<?php echo $y_pos[$i]+20 ?>" r="2" fill="#666" stroke="none" stroke-width="1" />
      <rect x="<?php echo $x_pos[$i]-34 ?>" y="<?php echo $y_pos[$i]+28 ?>" width="<?php taille_de_vignette($chiffre_in) ?>" height="13" fill="#fff" stroke="#999" stroke-width="1"/>
      <text transform="translate(<?php echo $x_pos[$i]-31 ?>,<?php echo $y_pos[$i]+38 ?>)" fill="#666" stroke="none" font-size="10" font-family="Verdana" ><?php echo $chiffre_in?></text>
    <?php endfor ?>
<!-- OUT -->
    <?php for ($i=0; $i < count($y_pos_d); $i++): ?>
      <?php $chiffre_out=number_format($chiffres_out[$i], 2, ',', ' ')." €" ?>
      <?php if ($y_pos_d[$i+1]!=0): ?> 
        <line x1="<?php echo $x_pos[$i] ?>" y1="<?php echo $y_pos_d[$i]+20 ?>" x2="<?php echo $x_pos[$i+1] ?>" y2="<?php echo $y_pos_d[$i+1]+20 ?>" stroke="#ccc" stroke-width="1" />
      <?php endif ?>
      <circle cx="<?php echo $x_pos[$i] ?>" cy="<?php echo $y_pos_d[$i]+20 ?>" r="2" fill="#ccc" stroke="none" stroke-width="1" />
      <rect x="<?php echo $x_pos[$i]-34 ?>" y="<?php echo $y_pos_d[$i]+28 ?>" width="<?php taille_de_vignette($chiffre_out) ?>" height="13" fill="white" stroke="#ccc" stroke-width="1"/>
      <text transform="translate(<?php echo $x_pos[$i]-31 ?>,<?php echo $y_pos_d[$i]+38 ?>)" fill="#666" stroke="none" font-size="10" font-family="Verdana" ><?php echo $chiffre_out?></text>
    <?php endfor ?>
<!-- IN MOINS OUT -->
    <?php for ($i=0; $i < count($y_pos_in_out); $i++): ?>
      <?php $chiffre_in_out=number_format($chiffres_in_out[$i], 2, ',', ' ')." €" ?>
      <?php if ($y_pos_in_out[$i+1]!=0): ?> 
        <line x1="<?php echo $x_pos[$i] ?>" y1="<?php echo $y_pos_in_out[$i]+20 ?>" x2="<?php echo $x_pos[$i+1] ?>" y2="<?php echo $y_pos_in_out[$i+1]+20 ?>" stroke-width="1" />
      <?php endif ?>
      <circle cx="<?php echo $x_pos[$i] ?>" cy="<?php echo $y_pos_in_out[$i]+20 ?>" r="2" fill="#000" stroke="none" stroke-width="1" />
      <rect x="<?php echo $x_pos[$i]-34 ?>" y="<?php echo $y_pos_in_out[$i]+28 ?>" width="<?php taille_de_vignette($chiffre_in_out) ?>" height="13" fill="white" stroke="#666" stroke-width="1"/>
      <text transform="translate(<?php echo $x_pos[$i]-31 ?>,<?php echo $y_pos_in_out[$i]+38 ?>)" stroke="none" font-size="10" font-family="Verdana" ><?php echo $chiffre_in_out?></text>
    <?php endfor ?>
  </g>
</svg>