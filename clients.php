<?php
include ('acces/cle.php');
include ('classes/interface.class.php');
$my_interface = new interface_();
$select_clients=mysql_query("SELECT * FROM clients ORDER BY ordre") or trigger_error(mysql_error(),E_USER_ERROR);
$search_clients=mysql_query("SELECT * FROM factures GROUP BY id_client");
$les_clients[]="";
while ($row_search = mysql_fetch_array($search_clients)){
	$les_clients[]=$row_search['id_client'];
}
?>
<?php $my_interface->set_title("Clients"); ?>
<?php $my_interface->get_header(); ?>
<?php include ('include/menu.php');?>
		<div class="contenu">
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
				while($c = mysql_fetch_array($select_clients)){
				?>
				<tr class="facture" id="element_<?php echo $c['id_client']; ?>">
					<td>
						<?php
						if(array_search($c['id_client'], $les_clients)==false){?>
							<a href="#" onclick="effacer_client(<?php echo "'".$c['denomination']."','".$c['id_client']."'";?>);return false;" title="Delete">
								<img src="images/icn-delete.png" alt="Delete" />
							</a>
						<?php
						}else{?>
							<a href="#" onclick="alert('Il existe une ou plusieurs factures au nom de <?php echo htmlspecialchars($c['denomination']);?>');return false;" title="Delete">
								<img src="images/icn-delete-off.png" alt="Delete" />
							</a>
						<?php
						}?>
						<a href="form_client.php?id=<?php echo $c['id_client']?>" title="Edit">
							<img src="images/icn-edit.png" alt="Edit"/>
						</a> 
						<a href="form_facture.php?id_client=<?php echo $c['id_client']?>" title="Nouvelle facture">
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
		</div>
	<script src="js/client_sortable.js" type="text/javascript"></script>
<?php $my_interface->get_footer(); ?>