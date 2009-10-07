<?php
date_default_timezone_set('Europe/Brussels');
include ('acces/cle.php');
include ('classes/interface.class.php');
$my_interface = new interface_();
if($_GET['annee']){
	$annee=$_GET['annee'];
}
if($_GET['id']){
	$id=$_GET['id'];
	$select_factures=mysql_query("SELECT * FROM factures WHERE id='$id'") or trigger_error(mysql_error(),E_USER_ERROR);
	$f = mysql_fetch_array($select_factures);
	extract($f);
	$date_array=explode("-",$date);
}else{
	$select_no=mysql_query("SELECT numero FROM factures ORDER BY date DESC, numero DESC LIMIT 1") or trigger_error(mysql_error(),E_USER_ERROR);
	$no = mysql_fetch_array($select_no);
	if(mysql_num_rows($select_no)>0){
		extract($no);
		$numero++;
	}else{
		$numero=1;
	}
}
if($_GET['id_client']){
	$id_client=$_GET['id_client'];
}
$select_clients=mysql_query("SELECT * FROM clients ORDER BY ordre") or trigger_error(mysql_error(),E_USER_ERROR);
?>
<?php $my_interface->set_title("Ajouter une factures sortantes"); ?>
<?php $my_interface->get_header(); ?>
<?php include ('include/menu.php');?>
	<div class="contenu">
		<h3>Nouvelle facture sortante</h3>
		<form method="post" action="requetes/insert_facture.php">
				<p>
					<label for="numero">Numéro : </label><?php echo $numero;?>
					<input name="numero" type="hidden" size="3" value="<?php echo $numero;?>" />
				</p>
				<p>
					<label>Date :</label>
					<input type="text" class="w2em" id="date-1-dd" name="jour" value="<?php if($date){echo $date_array[2];}else{echo date("d");}?>" maxlength="2" size="2" />
					<input type="text" class="w2em" id="date-1-mm" name="mois" value="<?php if($date){echo $date_array[1];}else{echo date("m");}?>" maxlength="2" size="2" />
					<input type="text" class="w4em split-date" id="date-1" name="lannee" value="<?php if($date){echo $date_array[0];}else{echo date("Y");}?>" maxlength="4" size="5" />
				</p>
				<p>
					<label for="id_client">Client : </label>
					<select name="id_client">
						<?php while($c= mysql_fetch_array($select_clients)){?>
							<option <?php if($id_client==$c['id_client']){echo 'selected="selected"';}?> value="<?php echo $c['id_client']?>"><?php echo htmlspecialchars($c['denomination'])?></option>
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
<?php $my_interface->get_footer(); ?>