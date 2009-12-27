<?php
include ('classes/interface.class.php');
$myInterface = new interface_();
$selectUtilisateur = mysql_query("SELECT * FROM `utilisateur`") or trigger_error(mysql_error(),E_USER_ERROR);
$utilisateur = mysql_fetch_array($selectUtilisateur);
if (is_array($utilisateur)) {
	extract($utilisateur);
} else {
	mysql_query("INSERT INTO `utilisateur` (`id`) VALUES (1)") or trigger_error(mysql_error(),E_USER_ERROR);
}
if (!isset($_GET['ajaxed'])) {
	$myInterface->set_title("Factures sortantes");
	$myInterface->get_header();
?>
	<div class="contenu" style="margin-top:70px;">
		<h3>Utilisateur</h3>
<?php } ?>
		<form id="utilisateur" method="post" action="requetes/updateUtilisateur.php">
				<input name="id" type="hidden" value="1" />
			<p>
				<label for="denomination">Dénomination : </label>
				<input id="denomination" name="denomination" type="text" value="<?php if(isset($denomination))echo $denomination?>" />
			</p>
			<p>
				<label for="nom">Nom : </label>
				<input id="nom" name="nom" type="text" value="<?php if(isset($nom))echo $nom?>" />
			</p>
			<p>
				<label for="prenom">Prénom : </label>
				<input id="prenom" name="prenom" type="text" value="<?php if(isset($prenom))echo $prenom?>" />
			</p>
			<p>
				<label for="legende">Légende : </label>
				<input id="legende" name="legende" type="text" value="<?php if(isset($legende))echo $legende?>" />
			</p>
			<p>
				<label for="adresse">Adresse : </label>
				<input id="adresse" name="adresse" type="text" value="<?php if(isset($adresse))echo $adresse?>" />
			</p>
			<p>
				<label for="numero">Numéro : </label>
				<input id="numero" name="numero" type="text" value="<?php if(isset($numero))echo $numero?>" />
			</p>
			<p>
				<label for="boite">Boîte : </label>
				<input id="boite" name="boite" type="text" value="<?php if(isset($boite))echo $boite?>" />
			</p>
			<p>
				<label for="codepostal">Code Postal : </label>
				<input id="codepostal" name="codepostal" type="text" value="<?php if(isset($codepostal))echo $codepostal?>" />
			</p>
			<p>
				<label for="localite">Localité : </label>
				<input id="localite" name="localite" type="text" value="<?php if(isset($localite))echo $localite?>" />
			</p>
			<p>
				<label for="telephone">Téléphone : </label>
				<input id="telephone" name="telephone" type="text" value="<?php if(isset($telephone))echo $telephone?>" />
			</p>
			<p>
				<label for="fax">Fax : </label>
				<input id="fax" name="fax" type="text" value="<?php if(isset($fax))echo $fax?>" />
			</p>
			<p>
				<label for="portable">Portable : </label>
				<input id="portable" name="portable" type="text" value="<?php if(isset($portable))echo $portable?>" />
			</p>
			<p>
				<label for="email">Email : </label>
				<input id="email" name="email" type="email" value="<?php if(isset($email))echo $email?>" />
			</p>
			<p>
				<label for="site">Site web : </label>
				<input id="site" name="site" type="url" value="<?php if(isset($site))echo $site?>" />
			</p>
			<p>
				<label for="tva">Numéro d'entreprise : </label>
				<input id="tva" name="tva" type="text" value="<?php if(isset($tva))echo $tva?>" />
			</p>
			<p>
				<label for="comptebancaire">Compte bancaire : </label>
				<input id="comptebancaire" name="comptebancaire" type="text" value="<?php if(isset($comptebancaire))echo $comptebancaire?>" />
			</p>
			<p>
				<label for="iban">Int. Bank Account Number (IBAN) : </label>
				<input id="iban" name="iban" type="text" value="<?php if(isset($iban))echo $iban?>" />
			</p>
			<p>
				<label for="bic">Code BIC : </label>
				<input id="bic" name="bic" type="text" value="<?php if(isset($bic))echo $bic?>" />
			</p>
			<p>
				<label for="validation">Validation : </label>
				<input id="validation" name="validation" type="submit" value="Envoyer" />
			</p>
		</form>
<?php if (!isset($_GET['ajaxed'])) { ?>
	</div>
<?php } ?>
<?php $myInterface->get_footer(); ?>