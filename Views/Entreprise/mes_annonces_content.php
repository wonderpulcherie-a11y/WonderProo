<?php if (!isset($entreprise)) die("Entreprise introuvable"); ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Mes annonces</h2>
            <p class="text-muted mb-0">Gérez vos publications et promotions.</p>
        </div>
        <a href="index.php?action=formAnnonce" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-circle me-1"></i> Nouvelle annonce
        </a>
    </div>

    <?php if (!empty($annonces)): ?>
        <div class="row g-4">
            <?php foreach ($annonces as $annonce): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <?php if (!empty($annonce->image) && file_exists($annonce->image)): ?>
                            <img src="<?= $annonce->image ?>" class="card-img-top" style="height:160px;object-fit:cover;" alt="">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="fw-bold"><?= htmlspecialchars($annonce->titre) ?></h5>
                            <p class="text-muted small">
                                <?= htmlspecialchars(mb_strimwidth($annonce->contenu, 0, 100, '...')) ?>
                            </p>
                            <small class="text-secondary">
                                <i class="bi bi-calendar3 me-1"></i>
                                <?= date("d/m/Y", strtotime($annonce->date_publication)) ?>
                            </small>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex gap-2 pb-3">
                            <a href="index.php?action=voirAnnonce&id=<?= $annonce->id_annonce ?>&source=dashboard"
                               class="btn btn-sm btn-outline-primary rounded-pill">Voir</a>
                            <a href="index.php?action=modifierAnnonce&id=<?= $annonce->id_annonce ?>"
                               class="btn btn-sm btn-outline-secondary rounded-pill">Modifier</a>
                            <a href="index.php?action=supprimerAnnonce&id=<?= $annonce->id_annonce ?>"
                               class="btn btn-sm btn-outline-danger rounded-pill"
                               onclick="return confirm('Supprimer cette annonce ?')">Supprimer</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info border-0 rounded-4 p-4 text-center">
            <i class="bi bi-megaphone fs-1 text-info d-block mb-2"></i>
            <h5 class="fw-bold">Aucune annonce publiée</h5>
            <p class="text-muted mb-3">Commencez par publier votre première annonce pour promouvoir votre activité.</p>
            <a href="index.php?action=formAnnonce" class="btn btn-primary rounded-pill">Publier une annonce</a>
        </div>
    <?php endif; ?>
</div>
