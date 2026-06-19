<?php
// Protection d'accès direct
if(!isset($entreprise)) {
    die("Entreprise introuvable");
}

$services = $services ?? [];
?>
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Gestion de mes services</h2>
            <p class="text-muted">Créez et gérez les différents services proposés par votre entreprise.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Formulaire d'ajout de service -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                <h4 class="fw-bold mb-3 text-primary">Nouveau service</h4>
                <hr class="mb-4">
                <form action="index.php?action=ajouterService" method="POST">
                    <div class="mb-3">
                        <label for="libelle" class="form-label fw-semibold">Nom du service <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg rounded-3" id="libelle" name="libelle" placeholder="Ex: Développement Web, Réparation Auto..." required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control rounded-3" id="description" name="description" rows="5" placeholder="Décrivez en quelques mots ce que contient ce service..."></textarea>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold shadow-sm">
                            <i class="bi bi-plus-circle me-2"></i> Ajouter le service
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des services existants -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                <h4 class="fw-bold mb-3 text-dark">Services enregistrés</h4>
                <hr class="mb-4">
                
                <?php if(!empty($services)): ?>
                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead class="table-primary text-white">
                                <tr>
                                    <th scope="col" style="border-top-left-radius: 10px; border-bottom-left-radius: 10px;">Service</th>
                                    <th scope="col">Description</th>
                                    <th scope="col" class="text-center" style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($services as $srv): ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-dark"><?= htmlspecialchars($srv->libelle) ?></span>
                                        </td>
                                        <td>
                                            <span class="text-secondary small"><?= nl2br(htmlspecialchars($srv->description ?? '')) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="index.php?action=supprimerService&id=<?= $srv->id_service ?>" 
                                               class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm"
                                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">
                                                <i class="bi bi-trash-fill me-1"></i> Supprimer
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info border-0 rounded-3 p-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill fs-3 me-3 text-info"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Aucun service enregistré</h6>
                                <p class="mb-0 text-secondary small">Utilisez le formulaire ci-contre pour ajouter votre tout premier service.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
