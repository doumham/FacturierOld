    <ul id="menu">
      <li id="m_factures"><a href="entrees.php?annee=<?php echo $annee ?>">Voir les factures sortantes</a><br /><a href="formEntree.php?annee=<?php echo $annee ?>" title="Créer une facture">Ajouter une facture</a></li>
      <li id="m_depenses"><a href="sorties.php?annee=<?php echo $annee ?>">Voir les factures entrantes</a><br /><a href="formSortie.php?annee=<?php echo $annee ?>" title="Ajouter une facture entrante">Ajouter une facture</a></li>
      <li id="m_clients"><a href="clients.php">Voir les clients</a><br /><a href="form_client.php">Ajouter un client</a></li>
      <li id="m_statistiques"><a href="statistiques.php?annee=<?php echo $annee ?>">Voir les statistiques</a><br /><a href="stats.php?annee=<?php echo $annee ?>" title="Graphique">Graphique</a></li>
      <li id="m_config"><a href="formUtilisateur.php">Compte utilisateur</a></li>
    </ul>
