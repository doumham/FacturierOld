<?php
function checkActif($page){
	if (strstr($_SERVER['PHP_SELF'], $page)){
		echo 'class="actif"';
	}
}
?>
		<ul id="onglets">
			<li <?php if(isset($_GET['type']) && $_GET['type'] == 'sortantes'){checkActif('factures.php');}; ?>><a href="factures.php?type=sortantes&amp;annee=<?php echo $annee ?>#bottom">Factures sortantes</a></li>
			<li <?php if(isset($_GET['type']) && $_GET['type'] == 'entrantes'){checkActif('factures.php');}; ?>><a href="factures.php?type=entrantes&amp;annee=<?php echo $annee ?>#bottom">Factures entrantes</a></li>
			<li <?php checkActif('statistiques.php'); ?>><a href="statistiques.php?annee=<?php echo $annee ?>">Statistiques</a></li>
			<li <?php checkActif('stats.php'); ?>><a href="stats.php?annee=<?php echo $annee ?>" title="Graphique">Graphique</a></li>
		</ul>