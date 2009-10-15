<?php
include ('acces/cle.php');
include ('classes/interface.class.php');
$myInterface = new interface_();
if($_GET['annee']){
	$annee = $_GET['annee'];
}else{
	$annee="all";
}
$selectClients=mysql_query("SELECT * FROM clients ORDER BY ordre") or trigger_error(mysql_error(),E_USER_ERROR);
$search_clients=mysql_query("SELECT * FROM facturesSortantes GROUP BY id_client");
$les_clients[]="";
while ($row_search = mysql_fetch_array($search_clients)){
	$les_clients[]=$row_search['id_client'];
}
?>
<?php $myInterface->set_title("Clients"); ?>
<?php $myInterface->get_header(); ?>
<?php include ('include/menu.php');?>
		<div class="contenu">
		<form action="requetes/delete.php" method="post">
			<p>
				<a href="formClient.php">Ajouter un client</a>
				<input type="submit" value="Supprimer les clients sélectionnées" id="boutonSupprimer" name="boutonSupprimer" />
				<input type="hidden" value="clients" name="table" />
				<input type="hidden" value="<?php echo $annee ?>" name="annee" />
			</p>
		<h3>Clients</h3>
		<table>
			<tr class="legende">
				<th>Outils</th>
				<th>Nom</th>
				<th>Adresse</th>
				<th>Code postal</th>
				<th>Localité</th>
				<th>Numéro de TVA</th>
			</tr>
			<tbody id="clients">
				<?php
				while($c = mysql_fetch_array($selectClients)){
				?>
				<tr class="facture" id="element_<?php echo $c['id_client']; ?>">
					<td>
						<?php
						if(array_search($c['id_client'], $les_clients)==false){?>
							<input type="checkbox" name="selectionElements[]" value="<?php echo $c['id_client'] ?>" />
						<?php
						}else{?>
							<input type="checkbox" name="selectionElements[]" value="<?php echo $c['id_client'] ?>" disabled="disabled" title="Il existe une ou plusieurs factures au nom de <?php echo htmlspecialchars($c['denomination']);?>" />
						<?php
						}?>
						<a href="formClient.php?id=<?php echo $c['id_client']?>" title="Edit">
							<img src="images/icn-edit.png" alt="Edit"/>
						</a> 
						<a href="formEntree.php?id_client=<?php echo $c['id_client']?>" title="Nouvelle facture">
							<img src="images/icn-add-facture.png" alt="New"/>
						</a> 
					</td>
					<td><?php echo htmlspecialchars($c['denomination'])?></td>
					<td><?php echo $c['adresse'].", ".$c['num']?></td>
					<td><?php echo $c['cp']?></td>
					<td><?php echo $c['localite']?></td>
					<td><?php echo $c['tva']?><input type="hidden" name="lesid[]" value="<?php echo $c['id_client']?>" /></td>
				</tr>
				<?php }?>
			</tbody>
			<tr class="tot_trimestre">
        <th colspan="6"></th>
		</table>
		</form>
		</div>
	<script src="js/client_sortable.js" type="text/javascript"></script>
<?php $myInterface->get_footer(); ?>