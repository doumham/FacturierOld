<?php
if(isset($_GET['annee'])){
	$annee = $_GET['annee'];
}else{
	$annee = "all";
}
if (isset($_GET['ajaxed']) && $_GET['ajaxed'] == 1) {
	include ('classes/interface.class.php');
	$myInterface = new interface_();
}
$type = "clients";
$selectClients = mysql_query("SELECT * FROM `clients` ORDER BY `denomination`") or trigger_error(mysql_error(),E_USER_ERROR);
$search_clients = mysql_query("SELECT * FROM `facturesSortantes` GROUP BY `id_client`");
$les_clients[] = "";
while ($row_search = mysql_fetch_array($search_clients)){
	$les_clients[] = $row_search['id_client'];
}
?>
<form id="listing" action="requetes/traitements.php" method="post">
	<p class="tools">
		<a href="formClient.php" class="button medium orange" id="boutonAjouterClient" title="Nouvelle fiche client">Créer une fiche client</a>
		<!-- <input type="submit" value="Ajouter un client" id="boutonAjouterClient" name="boutonAjouter" title="Ajouter un Client" /> -->
		<input type="submit" class="button medium mediumGrey" value="Supprimer les fiches sélectionnées" id="boutonSupprimer" name="boutonSupprimer" />
		<input type="hidden" name="type" value="<?php echo $type ?>" id="type" />
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
				if(array_search($c['id_client'], $les_clients) == false){?>
					<input type="checkbox" name="selectionElements[]" value="<?php echo $c['id_client'] ?>" />
				<?php
				}else{?>
					<input type="checkbox" name="selectionElements[]" value="<?php echo $c['id_client'] ?>" disabled="disabled" title="Il existe une ou plusieurs factures au nom de <?php echo htmlspecialchars($c['denomination']);?>" />
				<?php
				}?>
				<a class="button small mediumGrey modifier popup" href="formClient.php?id=<?php echo $c['id_client']?>" title="Modifier <?php echo htmlspecialchars($c['denomination']);?>">
					Modifier
				</a> 
			</td>
			<td><?php echo htmlspecialchars($c['denomination'])?></td>
			<td><?php echo $c['adresse']." ".$c['num']?></td>
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
