<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avis - <?= htmlspecialchars($entreprise->nom_entreprise) ?></title>
    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css">
</head>
<body class="bg-light">
<?php include './Views/partials/navbar.php'; ?>
<div class="container py-5">
    <div class="mb-4">
        <a href="index.php?action=detailsEntreprise&id=<?= $entreprise->id_entreprise ?>" class="btn btn-outline-secondary rounded-pill btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Retour au profil
        </a>
    </div>
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <h2 class="fw-bold">Avis sur <?= htmlspecialchars($entreprise->nom_entreprise) ?></h2>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-warning text-dark fs-6">
                <i class="bi bi-star-fill"></i> <?= number_format($moyenne ?? 0, 1) ?>/5
            </span>
            <span class="text-muted"><?= $totalAvis ?> avis</span>
        </div>
    </div>

    <?php if (!empty($commentaires)): ?>
        <?php foreach ($commentaires as $c): ?>
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <strong><?= htmlspecialchars(($c->nom ?? '') . ' ' . ($c->prenom ?? '')) ?></strong>
                        <div class="text-warning small">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star<?= $i <= $c->note ? '-fill' : '' ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <small class="text-muted"><?= date("d/m/Y", strtotime($c->date_commentaire)) ?></small>
                </div>
                <p class="mt-2 mb-0"><?= nl2br(htmlspecialchars($c->description)) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-secondary text-center rounded-4">Aucun avis pour le moment.</div>
    <?php endif; ?>
</div>
<?php include './Views/partials/footer.php'; ?>
</body>
</html>
