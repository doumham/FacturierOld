<?php
include('../acces/cle.php');
$id=$_GET['id'];
mysql_query("DELETE FROM clients WHERE id_client=$id") or die(mysql_error());
header("location:../clients.php");
?>