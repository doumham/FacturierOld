<?php
define(HOSTNAME, 'localhost');
define(DATABASE, 'facturier');
define(USERNAME, 'root');
define(PASSWORD, 'sam');

define(NEED_LOGIN, false);

define(FACTURIER_VERSION, '0.77b');
define(JQUERY_VERSION, '1.4.2');
define(JQUERY_UI_VERSION, '1.8rc3');

define(COUNTRY_CODE, 'fr_BE');
define(TIME_ZONE, 'Europe/Brussels');

define(ASSUJETTI_A_LA_TVA, true);
define(DEFAULT_TVA, '21,00');

error_reporting(E_ALL);

$db = mysql_connect(HOSTNAME, USERNAME, PASSWORD) or trigger_error(mysql_error(),E_USER_ERROR);
$select_db = mysql_select_db(DATABASE,$db) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_query("SET NAMES 'UTF8' ");

?>