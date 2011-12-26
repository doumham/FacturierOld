<?php
include('../include/config.php');
$table = $_GET['table'];
$champ = $_GET['champ'];
$select = mysql_query("SELECT DISTINCT `".$champ."` FROM `".$table."`") or trigger_error(mysql_error(),E_USER_ERROR);
while($f = mysql_fetch_array($select)){
	$return[] = htmlspecialchars($f[$champ]);
}
echo '["'.implode('","',$return).'"]';
?>