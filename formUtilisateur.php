<?php
include ('acces/cle.php');
include ('classes/interface.class.php');
$myInterface = new interface_();
$selectUtilisateur = mysql_query("SELECT * FROM `utilisateur`") or trigger_error(mysql_error(),E_USER_ERROR);
$utilisateur = mysql_fetch_array($selectUtilisateur);
extract($utilisateur);
$myInterface->set_title("Factures sortantes");
$myInterface->get_header();
include ('include/header.php');
?>
	<div class="contenu" style="margin-top:70px;">
		<h3>Utilisateur</h3>
		<form id="utilisateur" method="post" action="requetes/updateUtilisateur.php">
				<input name="id" type="hidden" value="<?php echo $id ?>" />
			<p>
				<label for="denomination">Dénomination : </label>
				<input id="denomination" name="denomination" type="text" value="<?php echo $denomination?>" />
			</p>
			<p>
				<label for="nom">Nom : </label>
				<input id="nom" name="nom" type="text" value="<?php echo $nom?>" />
			</p>
			<p>
				<label for="prenom">Prénom : </label>
				<input id="prenom" name="prenom" type="text" value="<?php echo $prenom?>" />
			</p>
			<p>
				<label for="legende">Légende : </label>
				<input id="legende" name="legende" type="text" value="<?php echo $legende?>" />
			</p>
			<p>
				<label for="adresse">Adresse : </label>
				<input id="adresse" name="adresse" type="text" value="<?php echo $adresse?>" />
			</p>
			<p>
				<label for="numero">Numéro : </label>
				<input id="numero" name="numero" type="text" value="<?php echo $numero?>" />
			</p>
			<p>
				<label for="boite">Boîte : </label>
				<input id="boite" name="boite" type="text" value="<?php echo $boite?>" />
			</p>
			<p>
				<label for="codepostal">Code Postal : </label>
				<input id="codepostal" name="codepostal" type="text" value="<?php echo $codepostal?>" />
			</p>
			<p>
				<label for="localite">Localité : </label>
				<input id="localite" name="localite" type="text" value="<?php echo $localite?>" />
			</p>
			<p>
				<label for="telephone">Téléphone : </label>
				<input id="telephone" name="telephone" type="text" value="<?php echo $telephone?>" />
			</p>
			<p>
				<label for="fax">Fax : </label>
				<input id="fax" name="fax" type="text" value="<?php echo $fax?>" />
			</p>
			<p>
				<label for="portable">Portable : </label>
				<input id="portable" name="portable" type="text" value="<?php echo $portable?>" />
			</p>
			<p>
				<label for="email">Email : </label>
				<input id="email" name="email" type="text" value="<?php echo $email?>" />
			</p>
			<p>
				<label for="site">Site web : </label>
				<input id="site" name="site" type="text" value="<?php echo $site?>" />
			</p>
			<p>
				<label for="tva">Numéro d'entreprise : </label>
				<input id="tva" name="tva" type="text" value="<?php echo $tva?>" />
			</p>
			<p>
				<label for="comptebancaire">Compte bancaire : </label>
				<input id="comptebancaire" name="comptebancaire" type="text" value="<?php echo $comptebancaire?>" />
			</p>
			<p>
				<label for="iban">Internationnal Bank Account Number (IBAN) : </label>
				<input id="iban" name="iban" type="text" value="<?php echo $iban?>" />
			</p>
			<p>
				<label for="bic">Code BIC : </label>
				<input id="bic" name="bic" type="text" value="<?php echo $bic?>" />
			</p>
			<p>
				<label for="validation">Validation : </label>
				<input id="validation" name="validation" type="submit" value="Envoyer" />
			</p>
		</form>
	</div>
<?php $myInterface->get_footer(); ?>