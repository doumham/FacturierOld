<?php
include ('acces/cle.php');
include ('classes/interface.class.php');
$myInterface = new interface_();
if($_GET['id']){
	$id=$_GET['id'];
	$selectClients=mysql_query("
		SELECT * FROM clients WHERE idClient='$id'"
		) or trigger_error(mysql_error(),E_USER_ERROR);
	$c=mysql_fetch_array($selectClients);
	extract($c);
}
?>
<?php $myInterface->set_title("Ajouter un client"); ?>
<?php $myInterface->get_header(); ?>
<?php include ('include/menu.php');?>
	<div class="contenu">
		<h3>Nouveau client</h3>
		<form method="post" action="requetes/insertClient.php">
			<p>
				<label for="denomination">Dénomination : </label>
				<input name="denomination" type="text" value="<?php echo htmlspecialchars($denomination)?>" />
			</p>
			<p>
				<label for="nom">Nom : </label>
				<input name="nom" type="text" value="<?php echo $nom?>" />
			</p>
			<p>
				<label for="prenom">Prénom : </label>
				<input name="prenom" type="text" value="<?php echo $prenom?>" />
			</p>
			<p>
				<label for="adresse">Adresse : </label>
				<input name="adresse" value="<?php echo $adresse?>" />
			</p>
			<p>
				<label for="num">Numéro : </label>
				<input name="num" value="<?php echo $num?>" />
			</p>
			<p>
				<label for="boite">Boîte : </label>
				<input name="boite" value="<?php echo $boite?>" />
			</p>
			<p>
				<label for="cp">Code Postal : </label>
				<input name="cp" value="<?php echo $cp?>" />
			</p>
			<p>
				<label for="localite">Localité : </label>
				<input name="localite" value="<?php echo $localite?>" />
			</p>
			<p>
				<label for="tel">Tel : </label>
				<input name="tel" value="<?php echo $tel?>" />
			</p>
			<p>
				<label for="email">Email : </label>
				<input name="email" value="<?php echo $email?>" />
			</p>
			<p>
				<label for="site">Site : </label>
				<input name="site" value="<?php echo $site?>" />
			</p>
			<p>
				<label for="tva">TVA : </label>
				<input name="tva" value="<?php echo $tva?>" />
			</p>
			<p>
				<label for="validation">Validation : </label>
				<input type="submit" value="Envoyer" />
				<input name="id" type="hidden" value="<?php echo $id?>" />			
			</p>
		</form>
	</div>
<?php $myInterface->get_footer(); ?>