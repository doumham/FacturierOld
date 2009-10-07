    <ul id="menu">
      <li id="m_factures"><a href="index.php?annee=<?php echo $annee ?>">Voir les factures sortantes</a><br /><a href="form_facture.php?annee=<?php echo $annee ?>" title="Créer une facture">Ajouter une facture</a></li>
      <li id="m_depenses"><a href="depenses.php?annee=<?php echo $annee ?>">Voir les factures entrantes</a><br /><a href="form_depense.php?annee=<?php echo $annee ?>" title="Ajouter une facture entrante">Ajouter une facture</a></li>
      <li id="m_clients"><a href="clients.php">Voir les clients</a><br /><a href="form_client.php">Ajouter un client</a></li>
      <li id="m_statistiques"><a href="statistiques.php?annee=<?php echo $annee ?>">Voir les statistiques</a><br /><a href="stats.php?annee=<?php echo $annee ?>" title="Graphique">Graphique</a></li>
      <li id="m_config"><a href="form_utilisateur.php">Compte utilisateur</a></li>
    </ul>
