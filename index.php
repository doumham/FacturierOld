<?php 
include ('classes/interface.class.php');
$myInterface = new interface_();
header("location:factures.php?type=sortantes&annee=".date('Y')."#bottom");
?>