<?php

$source = $_GET["source"] ?? "accueil";
if(!isset($annonce) || $annonce === false) {
    echo '<div class="container py-4"><div class="alert alert-danger">Annonce introuvable ou invalide.</div></div>';
    return;
}
?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h2 class="fw-bold mb-2"><?= htmlspecialchars($annonce->titre) ?></h2>
                            <p class="text-muted mb-0">Publié le <?= htmlspecialchars($annonce->date_publication) ?></p>
                        </div>
                        <span class="badge bg-primary rounded-3">Annonce</span>
                    </div>

                    <?php if(!empty($annonce->image)): ?>
                        <div class="mb-4 rounded-4 overflow-hidden">
                            <img src="<?= htmlspecialchars($annonce->image) ?>" alt="Image annonce" class="img-fluid w-100" style="max-height: 420px; object-fit: cover;">
                        </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <p class="text-muted"><?= nl2br(htmlspecialchars($annonce->contenu)) ?></p>
                    </div>

                    <div class="d-flex justify-content-between flex-column flex-sm-row gap-2">
                        <a href="<?= $source == 'dashboard' ? 'index.php?action=dashboardEntreprise' : 'index.php?action=accueil' ?>" class="btn btn-outline-secondary rounded-3">
                            <i class="bi bi-arrow-left me-2"></i>
                            <?= $source == 'dashboard' ? 'Retour au dashboard' : 'Retour à l\'accueil' ?>
                        </a>
                        <?php if($source == 'dashboard'): ?>
                            <a href="index.php?action=modifierAnnonce&id=<?= urlencode($annonce->id_annonce) ?>" class="btn btn-primary rounded-3">
                                <i class="bi bi-pencil-square me-2"></i> Modifier
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>