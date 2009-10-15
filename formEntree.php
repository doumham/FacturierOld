<?php
date_default_timezone_set('Europe/Brussels');
include ('acces/cle.php');
include ('classes/interface.class.php');
$myInterface = new interface_();
if($_GET['annee']){
	$annee=$_GET['annee'];
}
if($_GET['id']){
	$id=$_GET['id'];
	$selectFacturesSortantes=mysql_query("SELECT * FROM facturesSortantes WHERE id='$id'") or trigger_error(mysql_error(),E_USER_ERROR);
	$f = mysql_fetch_array($selectFacturesSortantes);
	extract($f);
	$dateArray=explode("-",$date);
}else{
	$select_no=mysql_query("SELECT numero FROM facturesSortantes ORDER BY date DESC, numero DESC LIMIT 1") or trigger_error(mysql_error(),E_USER_ERROR);
	$no = mysql_fetch_array($select_no);
	if(mysql_num_rows($select_no)>0){
		extract($no);
		$numero++;
	}else{
		$numero=1;
	}
}
if($_GET['idClient']){
	$idClient=$_GET['idClient'];
}
$selectClients=mysql_query("SELECT * FROM clients ORDER BY ordre") or trigger_error(mysql_error(),E_USER_ERROR);
?>
<?php $myInterface->set_title("Ajouter une facturesSortantes sortantes"); ?>
<?php $myInterface->get_header(); ?>
	<div class="contenu">
		<h3>Nouvelle facture sortante</h3>
		<form method="post" action="requetes/insertEntree.php">
				<p>
					<label for="numero">Numéro : </label>
					<input name="numero" readonly="readonly" disabled="disabled" type="text" size="3" value="<?php echo $numero;?>" />
				</p>
				<p>
					<label>Date :</label>
					<input type="text" class="w2em" id="date-1-dd" name="jour" value="<?php if($date){echo $dateArray[2];}else{echo date("d");}?>" maxlength="2" size="2" />
					<input type="text" class="w2em" id="date-1-mm" name="mois" value="<?php if($date){echo $dateArray[1];}else{echo date("m");}?>" maxlength="2" size="2" />
					<input type="text" class="w4em split-date" id="date-1" name="lannee" value="<?php if($date){echo $dateArray[0];}else{echo date("Y");}?>" maxlength="4" size="5" />
				</p>
				<p>
					<label for="idClient">Client : </label>
					<select name="idClient">
						<?php while($c= mysql_fetch_array($selectClients)){?>
							<option <?php if($idClient==$c['idClient']){echo 'selected="selected"';}?> value="<?php echo $c['idClient']?>"><?php echo htmlspecialchars($c['denomination'])?></option>
							<?php }?>
						</select>
					</p>
					<p>
						<label for="objet">Objet : </label>
						<textarea rows="10" cols="50" name="objet"><?php echo $objet?></textarea>
					</p>
					<p>
						<label for="montant">Montant : </label>
						<input name="montant" value="<?php echo $montant=strtr($montant, ".", ",");?>" />			
					</p>
					<p>
						<label for="pourcent_tva">TVA (%) : </label>
						<input name="pourcent_tva" value="<?php if($pourcent_tva){echo strtr($pourcent_tva, ".", ",");}else{echo "21";}?>" />			
					</p>
					<p>
						<label for="validation">Validation : </label>
						<input type="submit" value="Envoyer" />
						<input name="id" type="hidden" value="<?php echo $id?>" />			
						<input name="annee" type="hidden" value="<?php echo $annee?>" />			
					</p>
			</form>
		</div>
<?php $myInterface->get_footer(); ?>