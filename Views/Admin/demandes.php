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
    <title>Demandes en attente - Admin WonderPro</title>
    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Demandes en attente</h2>
        <a href="index.php?action=dashboardAdmin" class="btn btn-outline-primary rounded-pill">Retour au dashboard</a>
    </div>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Entreprise</th>
                        <th>Quartier</th>
                        <th>RCCM</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($demandes)): foreach ($demandes as $d): ?>
                        <tr>
                            <td class="fw-semibold"><?= htmlspecialchars($d->nom_entreprise) ?></td>
                            <td><?= htmlspecialchars($d->quartier) ?></td>
                            <td><?= htmlspecialchars($d->RCCM) ?></td>
                            <td><?= date("d/m/Y", strtotime($d->created_at)) ?></td>
                            <td>
                                <a href="index.php?action=validerEntreprise&id=<?= $d->id_entreprise ?>" class="btn btn-sm btn-success rounded-pill">Valider</a>
                                <a href="index.php?action=refuserEntreprise&id=<?= $d->id_entreprise ?>" class="btn btn-sm btn-danger rounded-pill">Refuser</a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Aucune demande en attente.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
