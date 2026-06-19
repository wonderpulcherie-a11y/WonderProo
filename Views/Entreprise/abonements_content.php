<?php
// Protection d'accès direct
if(!isset($entreprise)) {
    die("Entreprise introuvable");
}
$souscription = $souscription ?? null;
?>

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark">Mes Abonnements</h2>
        <p class="text-muted">Gérez votre souscription et renouvelez votre abonnement.</p>
    </div>

    <!-- État actuel de l'abonnement -->
    <div class="row g-4 mb-5">
        <?php if($souscription): ?>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h4 class="fw-bold text-primary">Abonnement Actif</h4>
                        <span class="badge bg-success">Actif</span>
                    </div>
                    <hr class="mb-4">
                    
                    <div class="mb-3">
                        <p class="text-muted small mb-1">Plan actuel</p>
                        <h5 class="fw-bold"><?= htmlspecialchars($souscription->id_abonnement) ?></h5>
                    </div>

                    <div class="mb-3">
                        <p class="text-muted small mb-1">Date d'expiration</p>
                        <h5 class="fw-bold text-dark">
                            <?php 
                                $date = new DateTime($souscription->date_expiration);
                                echo $date->format('d/m/Y');
                            ?>
                        </h5>
                    </div>

                    <div class="mb-4">
                        <p class="text-muted small mb-1">Jours restants</p>
                        <div class="progress bg-light" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: <?= min(100, ($joursRestants / 90) * 100) ?>%"></div>
                        </div>
                        <p class="text-muted small mt-2 mb-0"><?= $joursRestants ?> jours</p>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="index.php?action=renouvelerAbonnement" class="btn btn-primary btn-lg rounded-3 fw-bold">
                            <i class="bi bi-arrow-clockwise me-2"></i> Renouveler l'abonnement
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-light text-center">
                    <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun abonnement actif</h5>
                    <p class="text-muted small mb-3">Souscrivez à un plan pour débuter</p>
                    <a href="index.php?action=afficherAbonnements" class="btn btn-primary rounded-3">
                        <i class="bi bi-bag-check me-2"></i> Voir nos plans
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Caractéristiques de votre plan -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                <h4 class="fw-bold text-dark mb-4">Avantages de votre plan</h4>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span class="fw-semibold">Annonces illimitées</span>
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span class="fw-semibold">Profil entreprise complet</span>
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span class="fw-semibold">Gestion des services</span>
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span class="fw-semibold">Consultation des avis clients</span>
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span class="fw-semibold">Support client 24/7</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Nos plans disponibles -->
    <div class="mt-5">
        <h4 class="fw-bold mb-4">Explorez nos plans</h4>
        <div class="row g-4">
            <!-- Plan Standard -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white text-center h-100 transition-hover">
                    <div class="mb-3">
                        <i class="bi bi-box text-primary fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-1">STANDARD</h5>
                    <p class="text-muted small mb-3">3 mois</p>
                    <h3 class="fw-bold mb-3">5 000<span class="fs-5"> FCFA</span></h3>
                    <a href="index.php?action=souscrire&id=STANDARD" class="btn btn-primary btn-sm rounded-2">
                        Souscrire
                    </a>
                </div>
            </div>

            <!-- Plan VIP -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-3 border-primary shadow-sm p-4 rounded-4 bg-white text-center h-100 position-relative transition-hover">
                    <div class="badge bg-primary position-absolute top-0 start-50 translate-middle">Recommandé</div>
                    <div class="mb-3 mt-2">
                        <i class="bi bi-crown text-warning fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-1">VIP</h5>
                    <p class="text-muted small mb-3">6 mois</p>
                    <h3 class="fw-bold mb-3">9 000<span class="fs-5"> FCFA</span></h3>
                    <a href="index.php?action=souscrire&id=VIP" class="btn btn-primary btn-sm rounded-2">
                        Souscrire
                    </a>
                </div>
            </div>

            <!-- Plan VVIP -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white text-center h-100 transition-hover">
                    <div class="mb-3">
                        <i class="bi bi-gem text-danger fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-1">VVIP</h5>
                    <p class="text-muted small mb-3">1 an</p>
                    <h3 class="fw-bold mb-3">15 000<span class="fs-5"> FCFA</span></h3>
                    <a href="index.php?action=souscrire&id=VVIP" class="btn btn-primary btn-sm rounded-2">
                        Souscrire
                    </a>
                </div>
            </div>

            <!-- Plan Essai -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-light text-center h-100 transition-hover">
                    <div class="mb-3">
                        <i class="bi bi-gift text-info fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-1">ESSAI</h5>
                    <p class="text-muted small mb-3">3 mois</p>
                    <h3 class="fw-bold mb-3">Gratuit</h3>
                    <span class="btn btn-secondary btn-sm rounded-2 disabled">
                        Offre passée
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }
</style>
