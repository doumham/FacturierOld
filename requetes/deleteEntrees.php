<?php
include('../acces/cle.php');
$id=$_POST['id'];
mysql_query("DELETE FROM factures WHERE id=$id") or die(mysql_error());
header("location:../entrees.php");
?>