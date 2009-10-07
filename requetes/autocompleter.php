<?php
include('../acces/cle.php');
$sql = mysql_query("SELECT * FROM depenses WHERE objet LIKE '".$_POST['objet']."%' GROUP BY objet");
?>
<ul id="liste-autocompletion">
<?php
while ($select = mysql_fetch_array($sql)) {
	extract ($select);
	echo "<li>".$objet."</li>";
}
?>
</ul>
