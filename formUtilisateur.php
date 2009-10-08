<?php
include ('acces/cle.php');
include ('classes/interface.class.php');
$my_interface = new interface_();
include ('include/config.php');?>
<?php $my_interface->set_title("Factures sortantes");?>
<?php $my_interface->get_header();?>
<?php include ('include/menu.php');?>
	<div class="contenu">
		<h3>Utilisateur</h3>
		<form method="post" action="requetes/modifUtilisateur.php">
			<p>
				<label for="c_denomination">Dénomination : </label>
				<input name="c_denomination" type="text" value="<?php echo $c_denomination?>" />
			</p>
			<p>
				<label for="c_nom">Nom : </label>
				<input name="c_nom" type="text" value="<?php echo $c_nom?>" />
			</p>
			<p>
				<label for="c_prenom">Prénom : </label>
				<input name="c_prenom" type="text" value="<?php echo $c_prenom?>" />
			</p>
			<p>
				<label for="c_legende">Légende : </label>
				<input name="c_legende" type="text" value="<?php echo $c_legende?>" />
			</p>
			<p>
				<label for="c_adresse">Adresse : </label>
				<input name="c_adresse" value="<?php echo $c_adresse?>" />
			</p>
			<p>
				<label for="c_numero">Numéro : </label>
				<input name="c_numero" value="<?php echo $c_numero?>" />
			</p>
			<p>
				<label for="c_boite">Boîte : </label>
				<input name="c_boite" value="<?php echo $c_boite?>" />
			</p>
			<p>
				<label for="c_cp">Code Postal : </label>
				<input name="c_cp" value="<?php echo $c_cp?>" />
			</p>
			<p>
				<label for="c_localite">Localité : </label>
				<input name="c_localite" value="<?php echo $c_localite?>" />
			</p>
			<p>
				<label for="c_tel">Téléphone : </label>
				<input name="c_tel" value="<?php echo $c_tel?>" />
			</p>
			<p>
				<label for="c_fax">Fax : </label>
				<input name="c_fax" value="<?php echo $c_fax?>" />
			</p>
			<p>
				<label for="c_portable">Portable : </label>
				<input name="c_portable" value="<?php echo $c_portable?>" />
			</p>
			<p>
				<label for="c_email">Email : </label>
				<input name="c_email" value="<?php echo $c_email?>" />
			</p>
			<p>
				<label for="c_site">Site web : </label>
				<input name="c_site" value="<?php echo $c_site?>" />
			</p>
			<p>
				<label for="c_tva">Numéro d'entreprise : </label>
				<input name="c_tva" value="<?php echo $c_tva?>" />
			</p>
			<p>
				<label for="c_cb">Compte bancaire : </label>
				<input name="c_cb" value="<?php echo $c_cb?>" />
			</p>
			<p>
				<label for="c_iban">Code IBAN : </label>
				<input name="c_iban" value="<?php echo $c_iban?>" />
			</p>
			<p>
				<label for="validation">Validation : </label>
				<input name="validation" type="submit" value="Envoyer" />
			</p>
		</form>
	</div>
<?php $my_interface->get_footer(); ?>