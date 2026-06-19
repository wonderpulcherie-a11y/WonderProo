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
    <title>Catalogue des services - Admin WonderPro</title>
    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Catalogue des services</h2>
            <p class="text-muted mb-0">Services globaux liés aux entreprises</p>
        </div>
        <a href="index.php?action=dashboardAdmin" class="btn btn-outline-primary rounded-pill">Retour</a>
    </div>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Service</th>
                        <th>Description</th>
                        <th>Entreprises</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($services)): foreach ($services as $s): ?>
                        <tr>
                            <td class="fw-semibold"><?= htmlspecialchars($s->libelle) ?></td>
                            <td class="text-muted small"><?= htmlspecialchars(mb_strimwidth($s->description ?? '', 0, 80, '...')) ?></td>
                            <td><span class="badge bg-primary"><?= $s->nb_entreprises ?> entreprise(s)</span></td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="3" class="text-center text-muted py-4">Aucun service dans le catalogue.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
