<?php
$hostname = "localhost";
$database = "facturier";
$username = "root";
$password = "sam";
$db = mysql_connect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);
$select_db = mysql_select_db($database,$db) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_query("SET NAMES 'UTF8' ");
?>