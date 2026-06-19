<?php

if(!isset($entreprise)) {
    die("Entreprise introuvable");
}

$annonces = $annonces ?? [];
$souscription = $souscription ?? null;
$joursRestants = $joursRestants ?? 0;
$totalAvis = $totalAvis ?? 0;

?>

<style>
    .dashboard-topbar {
        background: #fff;
        padding: 24px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        margin-bottom: 30px;
    }

    .dashboard-card {
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: none;
    }

    .stat-card {
        border-radius: 20px;
        padding: 24px;
        color: white;
        min-height: 160px;
    }

    .stat-card h2 {
        font-size: 2.5rem;
        font-weight: 700;
    }

    .table-container,
    .subscription-card,
    .notification-box {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        padding: 24px;
    }

    .subscription-status {
        font-size: 0.95rem;
        padding: 0.7rem 1rem;
        border-radius: 999px;
    }

    .notification-item {
        border-bottom: 1px solid #e9ecef;
        padding: 16px 0;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    @media (max-width: 992px) {
        .dashboard-topbar {
            flex-direction: column;
            gap: 16px;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="dashboard-topbar d-flex justify-content-between align-items-start gap-3 flex-wrap">
        <div>
            <h3 class="fw-bold mb-2">Tableau de bord entreprise</h3>
            <p class="text-muted mb-0">Bienvenue <?= htmlspecialchars($entreprise->nom_entreprise) ?>, voici un aperçu rapide de votre activité.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="index.php?action=formAnnonce" class="btn btn-primary btn-lg rounded-3">
                <i class="bi bi-plus-circle me-2"></i> Nouvelle annonce
            </a>
            <a href="index.php?action=profilEntreprise" class="btn btn-outline-secondary btn-lg rounded-3">
                <i class="bi bi-pencil-square me-2"></i> Modifier profil
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="stat-card bg-primary">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h2 class="mb-1"><?= count($annonces) ?></h2>
                        <p class="mb-0 text-white-75">Annonces publiées</p>
                    </div>
                    <i class="bi bi-megaphone fs-1"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card bg-success">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h2 class="mb-1"><?= htmlspecialchars($entreprise->nombre_vues ?? 0) ?></h2>
                        <p class="mb-0 text-white-75">Vues</p>
                    </div>
                    <i class="bi bi-eye fs-1"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card bg-warning">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h2 class="mb-1"><?= htmlspecialchars($totalAvis) ?></h2>
                        <p class="mb-0 text-white-75">Commentaires</p>
                    </div>
                    <i class="bi bi-chat-dots fs-1"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card bg-danger">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h2 class="mb-1"><?= $joursRestants ?>j</h2>
                        <p class="mb-0 text-white-75">Avant expiration</p>
                    </div>
                    <i class="bi bi-alarm fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="table-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">Mes annonces</h4>
                        <p class="mb-0 text-muted">Gérez vos dernières publications.</p>
                    </div>
                    <a href="index.php?action=formAnnonce" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> Nouvelle annonce
                    </a>
                </div>

                <?php if(!empty($annonces)): ?>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Titre</th>
                                    <th>Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($annonces as $annonce): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($annonce->titre) ?></td>
                                        <td><?= htmlspecialchars($annonce->date_publication) ?></td>
                                        <td class="text-end">
                                            <a href="index.php?action=voirAnnonce&id=<?= urlencode($annonce->id_annonce) ?>&source=dashboard" class="btn btn-sm btn-outline-primary rounded-3 me-1"><i class="bi bi-eye "></i></a>
                                            <a href="index.php?action=modifierAnnonce&id=<?= urlencode($annonce->id_annonce) ?>" class="btn btn-sm btn-outline-warning rounded-3 me-1"><i class="bi bi-pencil-square"></i></a>
                                            <a href="index.php?action=supprimerAnnonce&id=<?= urlencode($annonce->id_annonce) ?>" class="btn btn-sm btn-outline-danger rounded-3" onclick="return confirm('Supprimer cette annonce ?')"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info mb-0">
                        Vous n'avez publié aucune annonce pour le moment.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="subscription-card mb-4">
                <h5 class="fw-bold mb-3">Mon abonnement</h5>
                <p class="mb-2"><strong>Formule :</strong> <?= $souscription ? htmlspecialchars($souscription->type_abonnement) : 'Aucun abonnement' ?></p>
                <p class="mb-2"><strong>Expiration :</strong> <?= $souscription ? htmlspecialchars($souscription->date_expiration) : '-' ?></p>
                <p class="mb-3"><span class="badge bg-success subscription-status"><?= $souscription ? htmlspecialchars(ucfirst($souscription->statut)) : 'Aucun abonnement' ?></span></p>
                <a href="index.php?action=renouvelerAbonnement" class="btn btn-primary w-100 rounded-3">Renouveler</a>
            </div>
            <!-- <div class="notification-box">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Notifications</h5>
                    <a href="index.php?action=notifications" class="btn btn-sm btn-outline-primary rounded-pill">
                        Voir toutes
                    </a>
                </div>
                <div class="notification-item">
                    <p class="mb-1 fw-semibold">Votre abonnement expire bientôt</p>
                    <small class="text-muted">Il y a 1 heure</small>
                </div>
                <div class="notification-item">
                    <p class="mb-1 fw-semibold">Paiement confirmé</p>
                    <small class="text-muted">Hier</small>
                </div>
                <div class="notification-item">
                    <p class="mb-1 fw-semibold">Nouvelle vue sur votre entreprise</p>
                    <small class="text-muted">Aujourd'hui</small>
                </div>
            </div> -->
        </div>
    </div>
</div>
