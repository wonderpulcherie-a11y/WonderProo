<?php
// Protection d'accès direct
if(!isset($entreprise)) {
    die("Entreprise introuvable");
}
?>
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Mon Profil</h2>
            <p class="text-muted">Gérez les informations publiques de votre entreprise et vos coordonnées de contact.</p>
        </div>
    </div>

    <!-- Formulaire d'édition de profil -->
    <form action="index.php?action=updateProfil" method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            
            <!-- Colonne de gauche : Informations professionnelles -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white mb-4">
                    <h4 class="fw-bold mb-3 text-primary"><i class="bi bi-building me-2"></i> Informations Entreprise</h4>
                    <hr class="mb-4">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nom_entreprise" class="form-label fw-semibold">Nom de l'entreprise <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="nom_entreprise" name="nom_entreprise" 
                                   value="<?= htmlspecialchars($entreprise->nom_entreprise) ?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="quartier" class="form-label fw-semibold">Quartier <span class="text-danger">*</span></label>
                            <select class="form-select rounded-3" id="quartier" name="quartier" required>
                                <option value="Tamdja" <?= $entreprise->quartier == 'Tamdja' ? 'selected' : '' ?>>Tamdja</option>
                                <option value="Akwa" <?= $entreprise->quartier == 'Akwa' ? 'selected' : '' ?>>Carrefour Akwa</option>
                                <option value="Banengo" <?= $entreprise->quartier == 'Banengo' ? 'selected' : '' ?>>Banengo</option>
                                <option value="Djeleng" <?= $entreprise->quartier == 'Djeleng' ? 'selected' : '' ?>>Djeleng</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="site_web" class="form-label fw-semibold">Site Web</label>
                            <input type="url" class="form-control rounded-3" id="site_web" name="site_web" 
                                   placeholder="https://example.com" value="<?= htmlspecialchars($entreprise->site_web ?? '') ?>">
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="form-label fw-semibold">Description de l'activité</label>
                            <textarea class="form-control rounded-3" id="description" name="description" rows="5" required><?= htmlspecialchars($entreprise->description ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                    <h4 class="fw-bold mb-3 text-primary"><i class="bi bi-person-circle me-2"></i> Représentant & Contact</h4>
                    <hr class="mb-4">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label fw-semibold">Nom du représentant <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="nom" name="nom" 
                                   value="<?= htmlspecialchars($entreprise->nom) ?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="prenom" class="form-label fw-semibold">Prénom du représentant</label>
                            <input type="text" class="form-control rounded-3" id="prenom" name="prenom" 
                                   value="<?= htmlspecialchars($entreprise->prenom ?? '') ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Adresse Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control rounded-3" id="email" name="email" 
                                   value="<?= htmlspecialchars($entreprise->email) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="telephone" class="form-label fw-semibold">Téléphone de contact</label>
                            <input type="text" class="form-control rounded-3" id="telephone" name="telephone" 
                                   value="<?= htmlspecialchars($entreprise->telephone ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne de droite : Logo et validation -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white text-center mb-4">
                    <h4 class="fw-bold mb-3 text-dark">Logo de l'entreprise</h4>
                    <hr class="mb-4">
                    
                    <div class="mb-4 d-flex justify-content-center">
                        <?php if(!empty($entreprise->logo) && file_exists($entreprise->logo)): ?>
                            <div class="position-relative">
                                <img src="<?= $entreprise->logo ?>" class="img-thumbnail rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover;" alt="Logo <?= htmlspecialchars($entreprise->nom_entreprise) ?>">
                                <div class="form-check mt-3 text-start d-inline-block">
                                    <input class="form-check-input" type="checkbox" name="supprimer_logo" value="1" id="supprimer_logo">
                                    <label class="form-check-label text-danger fw-semibold small" for="supprimer_logo">
                                        Supprimer ce logo
                                    </label>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 150px; height: 150px; font-size: 60px;">
                                <?= strtoupper(substr($entreprise->nom_entreprise, 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label fw-semibold text-start w-100">Changer de logo</label>
                        <input class="form-control rounded-3" type="file" id="logo" name="logo" accept="image/*">
                        <div class="form-text text-muted small text-start">Formats acceptés : JPG, PNG, GIF, WEBP.</div>
                    </div>
                </div>

                <!-- Bouton de validation -->
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                    <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold shadow-sm w-100 py-3">
                        <i class="bi bi-save2 me-2"></i> Enregistrer les modifications
                    </button>
                    <a href="index.php?action=dashboardEntreprise" class="btn btn-outline-secondary rounded-3 fw-semibold w-100 mt-2 py-2">
                        Annuler
                    </a>
                </div>
            </div>
            
        </div>
    </form>
</div>
