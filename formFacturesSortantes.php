<?php
$id_client = '';

date_default_timezone_set('Europe/Brussels');
include ('acces/cle.php');
include ('include/config.php');
include ('classes/interface.class.php');
$myInterface = new interface_();
if(isset($_GET['annee']) && $_GET['annee']){
	$annee = $_GET['annee'];
}
if(isset($_GET['type']) && $_GET['type']){
	$type = $_GET['type'];
}
if(isset($_GET['id']) && $_GET['id']){
	$id = $_GET['id'];
	$selectFacturesSortantes = mysql_query("SELECT * FROM `facturesSortantes` WHERE `id`='$id'") or trigger_error(mysql_error(),E_USER_ERROR);
	$f = mysql_fetch_array($selectFacturesSortantes);
	extract($f);
	$dateArray = explode("-",$date);
}else{
	$select_no = mysql_query("SELECT `numero` FROM `facturesSortantes` ORDER BY `date` DESC, `numero` DESC LIMIT 1") or trigger_error(mysql_error(),E_USER_ERROR);
	$no = mysql_fetch_array($select_no);
	if(mysql_num_rows($select_no) > 0){
		extract($no);
		$numero++;
	}else{
		$numero = 1;
	}
}
if(isset($_GET['id_client']) && $_GET['id_client']){
	$id_client = $_GET['id_client'];
}
$selectClients = mysql_query("SELECT * FROM `clients` ORDER BY `ordre`") or trigger_error(mysql_error(),E_USER_ERROR);

if (!isset($_GET['ajaxed'])) {
	$myInterface->set_title("Ajouter une facture sortante");
	$myInterface->get_header();
}
?>
	<form method="post" action="requetes/insertFactureSortante.php">
		<input name="id" type="hidden" value="<?php if(isset($id)){echo $id;}?>" />			
		<input name="type" type="hidden" value="<?php if(isset($type)){echo $type;}?>" />			
		<input name="annee" type="hidden" value="<?php if(isset($annee)){echo $annee;}?>" />			
		<p>
			<label for="numero">Numéro : </label>
			<input name="numero" type="text" size="4" value="<?php echo $numero;?>" />
		</p>
		<p>
			<label>Date :</label>
			<input type="number" name="jour" value="<?php if(isset($date) && $date){echo $dateArray[2];}else{echo date("d");}?>" maxlength="2" size="2" />
			<input type="number" name="mois" value="<?php if(isset($date) && $date){echo $dateArray[1];}else{echo date("m");}?>" maxlength="2" size="2" />
			<input type="number" name="lannee" value="<?php if(isset($date) && $date){echo $dateArray[0];}else{echo date("Y");}?>" maxlength="4" size="4" />
		</p>
		<p>
			<label for="id_client">Client : </label>
			<select name="id_client" id="id_client">
<?php while($c = mysql_fetch_array($selectClients)){?>
				<option <?php if($id_client == $c['id_client']){echo 'selected="selected"';}?> value="<?php echo $c['id_client']?>"><?php echo htmlspecialchars($c['denomination'])?></option>
<?php }?>
			</select>
		</p>
		<p>
			<label for="objet">Objet : </label>
			<textarea rows="10" cols="50" name="objet" id="objet"><?php if(isset($objet))echo $objet?></textarea>
		</p>
		<p>
			<label for="montant">Montant : </label>
			<input name="montant" value="<?php if(isset($montant))echo $montant=strtr($montant, ".", ",");?>" id="montant" required="required" />			
		</p>
		<p>
			<label for="pourcent_tva">TVA (%) : </label>
			<input name="pourcent_tva" value="<?php if(isset($pourcent_tva) && !empty($pourcent_tva)){echo strtr($pourcent_tva, ".", ",");}else{echo DEFAULT_TVA;}?>" id="pourcent_tva" />			
		</p>
		<p>
			<label for="validation">Validation : </label>
			<input type="submit" value="Envoyer" id="validation" />
		</p>
	</form>
<?php $myInterface->get_footer(); ?>