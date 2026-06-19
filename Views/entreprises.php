<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuaire des entreprises - WonderPro</title>
    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css">
    <style>
        body { background-color: #f5f7fb; }
        .company-card { transition: transform 0.2s, box-shadow 0.2s; border-radius: 15px; }
        .company-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important; }
        .filter-bar { background: #fff; border-radius: 15px; padding: 24px; }
        .hero-banner { background: linear-gradient(135deg, #0d6efd, #0b5ed7); }
    </style>
</head>
<body>

<?php include './Views/partials/navbar.php'; ?>

<section class="hero-banner text-white py-5 mb-4 shadow-sm">
    <div class="container text-center">
        <h1 class="fw-bold">Annuaire des entreprises</h1>
        <p class="lead mb-0">Trouvez les meilleurs professionnels à Bafoussam</p>
    </div>
</section>

<main class="container mb-5">
    <div class="filter-bar shadow-sm mb-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-funnel-fill text-primary me-2"></i>Rechercher et filtrer</h5>
        <form action="index.php" method="GET">
            <input type="hidden" name="action" value="entreprises">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary small">Nom ou mot-clé</label>
                    <input type="text" name="motcle" class="form-control" placeholder="Ex: Envol, Santé..."
                           value="<?= htmlspecialchars($motcle ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary small">Quartier</label>
                    <select name="quartier" class="form-select">
                        <option value="">Tous</option>
                        <?php
                        $quartiers = ["Tamdja", "Akwa", "Banengo", "Djeleng"];
                        foreach ($quartiers as $q):
                        ?>
                            <option value="<?= $q ?>" <?= ($quartier ?? '') == $q ? 'selected' : '' ?>><?= $q ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary small">Domaine</label>
                    <select name="domaine" class="form-select">
                        <option value="">Tous les domaines</option>
                        <?php if (!empty($domaines)): foreach ($domaines as $dom): ?>
                            <option value="<?= htmlspecialchars($dom->nom_domaine) ?>"
                                <?= ($domaine ?? '') == $dom->nom_domaine ? 'selected' : '' ?>>
                                <?= htmlspecialchars($dom->nom_domaine) ?>
                            </option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary small">Service</label>
                    <select name="service" class="form-select">
                        <option value="">Tous</option>
                        <?php if (!empty($services)): foreach ($services as $srv): ?>
                            <option value="<?= htmlspecialchars($srv->libelle) ?>"
                                <?= ($service ?? '') == $srv->libelle ? 'selected' : '' ?>>
                                <?= htmlspecialchars($srv->libelle) ?>
                            </option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">
                        <i class="bi bi-search me-1"></i> Filtrer
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-3 shadow-sm">
        <span class="text-muted fw-medium">
            <?= count($entreprises ?: []) ?> entreprise(s) trouvée(s)
        </span>
    </div>

    <div class="row row-cols-1 g-3">
        <?php if (!empty($entreprises)): ?>
            <?php foreach ($entreprises as $ent): ?>
                <div class="col">
                    <div class="card company-card border-0 shadow-sm bg-white">
                        <div class="row g-0 align-items-center">
                            <div class="col-sm-2 d-flex justify-content-center py-4 bg-light">
                                <?php if (!empty($ent->logo) && file_exists($ent->logo)): ?>
                                    <img src="<?= $ent->logo ?>" class="rounded-circle shadow-sm"
                                         style="width:65px;height:65px;object-fit:cover;" alt="Logo">
                                <?php else: ?>
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-sm"
                                         style="width:65px;height:65px;font-size:1.4rem;">
                                        <?= strtoupper(substr($ent->nom_entreprise, 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-10">
                                <div class="card-body p-3">
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                                        <div>
                                            <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($ent->nom_entreprise) ?></h5>
                                            <span class="text-muted small">
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                                <?= htmlspecialchars($ent->quartier) ?>, Bafoussam
                                            </span>
                                        </div>
                                        <a href="index.php?action=detailsEntreprise&id=<?= $ent->id_entreprise ?>"
                                           class="btn btn-sm btn-outline-primary rounded-pill px-3">Voir le profil</a>
                                    </div>
                                    <p class="text-secondary small mb-0 mt-2">
                                        <?= htmlspecialchars(mb_strimwidth($ent->description ?? '', 0, 200, '...')) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5 bg-white rounded-3 shadow-sm">
                <i class="bi bi-search text-muted fs-1"></i>
                <p class="text-muted mt-2 mb-0">Aucune entreprise ne correspond à vos critères.</p>
                <a href="index.php?action=entreprises" class="btn btn-outline-primary rounded-pill mt-3">Réinitialiser les filtres</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include './Views/partials/footer.php'; ?>
<script src="src/bootstrap-5.3.8/js/bootstrap.bundle.min.js"></script>
</body>
</html>
