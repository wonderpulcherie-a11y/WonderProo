<?php
if (!isset($_SESSION["id_utilisateur"]) || $_SESSION["type"] != "Admin") {
    header("Location: index.php?action=connexion");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiements - Admin WonderPro</title>
    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Paiements</h2>
            <p class="text-muted mb-0">Revenus cumulés : <strong><?= number_format($revenus->total ?? 0, 0, ',', ' ') ?> FCFA</strong></p>
        </div>
        <a href="index.php?action=dashboardAdmin" class="btn btn-outline-primary rounded-pill">Retour</a>
    </div>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Référence</th>
                        <th>Entreprise</th>
                        <th>Montant</th>
                        <th>Mode</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($paiements)): foreach ($paiements as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p->reference_transaction) ?></td>
                            <td><?= htmlspecialchars($p->nom_entreprise ?? 'N/A') ?></td>
                            <td><?= number_format($p->montant, 0, ',', ' ') ?> FCFA</td>
                            <td><?= htmlspecialchars($p->mode_paiement) ?></td>
                            <td><span class="badge bg-<?= $p->statut_paiement == 'effectue' ? 'success' : 'warning' ?>"><?= $p->statut_paiement ?></span></td>
                            <td><?= date("d/m/Y H:i", strtotime($p->date_paiement)) ?></td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Aucun paiement enregistré.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
