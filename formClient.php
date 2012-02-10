<?php
include ('classes/interface.class.php');
$myInterface = new interface_();
$id = '';
$denomination = '';
$refClient = '';
$nom = '';
$prenom = '';
$adresse = '';
$num = '';
$boite = '';
$cp = '';
$localite = '';
$pays = '';
$tel = '';
$email = '';
$site = '';
$tva = '';
if(isset($_GET['id']) && !empty($_GET['id'])){
	$id = $_GET['id'];
	$selectClients=mysql_query("
		SELECT * FROM clients WHERE id_client='$id'"
		) or trigger_error(mysql_error(),E_USER_ERROR);
	$c = mysql_fetch_array($selectClients);
	extract($c);
}
if (!isset($_GET['ajaxed'])) {
	$myInterface->set_title("Facturier – Client");
	$myInterface->get_header();
}
?>
		<form id="client" method="post" action="requetes/insertClient.php">
			<fieldset id="firstFieldset">
				<p>
					<label for="denomination">Société : </label>
					<input name="denomination" type="text" value="<?php echo htmlspecialchars($denomination)?>" id="denomination" autofocus="autofocus" required="required" />
				</p>
				<p>
					<label for="refClient">Ref. client : </label>
					<input name="refClient" type="text" value="<?php echo htmlspecialchars($refClient)?>" id="refClient" />
				</p>
				<p>
					<label for="nom">Nom : </label>
					<input name="nom" type="text" value="<?php echo htmlspecialchars($nom)?>" id="nom" />
				</p>
				<p>
					<label for="prenom">Prénom : </label>
					<input name="prenom" type="text" value="<?php echo htmlspecialchars($prenom)?>" id="prenom" />
				</p>
				<p>
					<label for="tva">TVA : </label>
					<input name="tva" type="text" value="<?php echo $tva?>" id="tva" />
				</p>
				<p>
					<label for="tel">Tel : </label>
					<input name="tel" type="text" value="<?php echo htmlspecialchars($tel)?>" id="tel" />
				</p>
				<p>
					<label for="email">Email : </label>
					<input name="email" type="email" value="<?php echo $email?>" id="email" />
				</p>
				<p>
					<label for="site">Site : </label>
					<input name="site" type="text" value="<?php echo htmlspecialchars($site)?>" id="site" />
				</p>
			</fieldset>
			<fieldset>
				<p>
					<label for="adresse">Adresse : </label>
					<input name="adresse" type="text" value="<?php echo htmlspecialchars($adresse)?>" id="adresse" />
				</p>
				<p>
					<label for="num">Numéro : </label>
					<input name="num" type="text" value="<?php echo htmlspecialchars($num)?>" id="num" />
				</p>
				<p>
					<label for="boite">Boîte : </label>
					<input name="boite" type="text" value="<?php echo htmlspecialchars($boite)?>" id="boite" />
				</p>
				<p>
					<label for="cp">Code Postal : </label>
					<input name="cp" type="text" value="<?php echo $cp?>" id="cp" />
				</p>
				<p>
					<label for="localite">Localité : </label>
					<input name="localite" type="text" value="<?php echo htmlspecialchars($localite)?>" id="localite" />
				</p>
				<p>
					<label for="pays">Pays : </label>
					<input name="pays" type="text" value="<?php echo htmlspecialchars($pays)?>" id="pays" />
				</p>
			</fieldset>
			<p>
				<input type="submit" type="text" value="Enregistrer" id="validation" />
			</p>
			<input name="id" type="hidden" value="<?php echo $id?>" />			
		</form>
<?php $myInterface->get_footer(); ?>
