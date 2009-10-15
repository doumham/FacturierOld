<?php
function checkActif($page){
	if (ereg($page, $_SERVER['PHP_SELF'])){
		echo 'class="actif"';
	}
}
?>
		<ul id="onglets">
			<li><a <?php checkActif('facturesSortantes.php'); ?> href="facturesSortantes.php?annee=<?php echo $annee ?>">Factures sortantes</a></li>
			<li><a <?php checkActif('facturesEntrantes.php'); ?> href="facturesEntrantes.php?annee=<?php echo $annee ?>">Factures entrantes</a></li>
			<li><a <?php checkActif('statistiques.php'); ?> href="statistiques.php?annee=<?php echo $annee ?>">Statistiques</a></li>
			<li><a <?php checkActif('stats.php'); ?> href="stats.php?annee=<?php echo $annee ?>" title="Graphique">Graphique</a></li>
		</ul>