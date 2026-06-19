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
    <title>Domaines d'activité - Admin WonderPro</title>
    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Domaines d'activité</h2>
        <a href="index.php?action=dashboardAdmin" class="btn btn-outline-primary rounded-pill">Retour</a>
    </div>
    <div class="row g-3">
        <?php if (!empty($domaines)): foreach ($domaines as $d): ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="bi bi-briefcase-fill text-primary fs-4"></i>
                        <h5 class="fw-bold mb-0"><?= htmlspecialchars($d->nom_domaine) ?></h5>
                    </div>
                    <p class="text-muted small mb-0"><?= htmlspecialchars($d->description ?? '') ?></p>
                </div>
            </div>
        <?php endforeach; else: ?>
            <div class="col-12 text-center text-muted py-5">Aucun domaine enregistré.</div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
