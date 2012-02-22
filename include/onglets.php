<?php
function checkActif($page){
	if (strstr($_SERVER['PHP_SELF'], $page)){
		echo 'class="actif"';
	}
}
?>
		<ul id="onglets">
			<li <?php checkActif('contrats.php'); ?>><a href="contrats.php<?php if(isset($annee)){ ?>?annee=<?php echo $annee ?><?php } ?>#bottom">Contrats</a></li>
			<li <?php if(isset($_GET['type']) && $_GET['type'] == 'sortantes'){checkActif('factures.php');}; ?>><a href="factures.php?type=sortantes<?php if(isset($annee)){ ?>&amp;annee=<?php echo $annee ?><?php } ?>#bottom">Factures sortantes</a></li>
<?php if (FACTURES_ENTRANTES): ?>
			<li <?php if(isset($_GET['type']) && $_GET['type'] == 'entrantes'){checkActif('factures.php');}; ?>><a href="factures.php?type=entrantes<?php if(isset($annee)){ ?>&amp;annee=<?php echo $annee ?><?php } ?>#bottom">Factures entrantes</a></li>
<?php endif ?>
			<li <?php checkActif('clients.php'); ?>><a href="clients.php<?php if(isset($annee)){ ?>?annee=<?php echo $annee ?><?php } ?>">Clients</a></li>
<?php if (STATISTIQUES): ?>
			<li <?php checkActif('statistiques.php'); ?>><a href="statistiques.php<?php if(isset($annee)){ ?>?annee=<?php echo $annee ?><?php } ?>">Statistiques</a></li>	
<?php endif ?>
			<li <?php checkActif('graphique.php'); ?>><a href="graphique.php<?php if(isset($annee)){ ?>?annee=<?php echo $annee ?><?php } ?>" title="Graphique">Graphique</a></li>
		</ul>
