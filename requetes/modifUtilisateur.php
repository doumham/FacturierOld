<?php
extract($_POST);

$somecontent="
<?php
\$c_denomination=\"$c_denomination\";
\$c_nom=\"$c_nom\";
\$c_prenom=\"$c_prenom\";
\$c_legende=\"$c_legende\";
\$c_adresse=\"$c_adresse\";
\$c_numero=\"$c_numero\";
\$c_boite=\"$c_boite\";
\$c_cp=\"$c_cp\";
\$c_localite=\"$c_localite\";
\$c_tel=\"$c_tel\";
\$c_fax=\"$c_fax\";
\$c_portable=\"$c_portable\";
\$c_email=\"$c_email\";
\$c_site=\"$c_site\";
\$c_tva=\"$c_tva\";
\$c_cb=\"$c_cb\";
\$c_iban=\"$c_iban\";
?>
";

$filename = '../include/config.php';
if (is_writable($filename)) {
    if (!$handle = fopen($filename, 'w')) {
			 echo "Impossible d'ouvrir le fichier ($filename)";
			 exit;
    }
    if (fwrite($handle, $somecontent) === FALSE) {
       echo "Impossible d'écrire dans le fichier ($filename)";
       exit;
    }
    fclose($handle);
		header("location:../facturesSortantes.php?utilisateur=OK");
} else {
    echo "Le fichier $filename n'est pas accessible en écriture.";
}

?>
