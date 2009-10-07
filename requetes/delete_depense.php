<?php
include('../acces/cle.php');
$id=$_GET['id'];
mysql_query("DELETE FROM depenses WHERE id=$id") or die(mysql_error());
header("location:../depenses.php");
?>