<?php
function checkActif($page){
	if (ereg($page, $_SERVER['PHP_SELF'])){
		echo 'class="actif"';
	}
}
?>
		<ul id="onglets">
			<li <?php checkActif('facturesSortantes.php'); ?>><a href="facturesSortantes.php?annee=<?php echo $annee ?>">Factures sortantes</a></li>
			<li <?php checkActif('facturesEntrantes.php'); ?>><a href="facturesEntrantes.php?annee=<?php echo $annee ?>">Factures entrantes</a></li>
			<li <?php checkActif('statistiques.php'); ?>><a href="statistiques.php?annee=<?php echo $annee ?>">Statistiques</a></li>
			<li <?php checkActif('stats.php'); ?>><a href="stats.php?annee=<?php echo $annee ?>" title="Graphique">Graphique</a></li>
		</ul>