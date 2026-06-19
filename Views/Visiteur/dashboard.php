<?php
// Protection d'accès direct
if(!isset($visiteur)) {
    die("Visiteur introuvable");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace Visiteur - WonderPro</title>
    
    <!-- Scripts & Styles locaux -->
    <script src="src/bootstrap-5.3.8/js/bootstrap.bundle.min.js"></script>
    <script src="src/bootstrap-5.3.8/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f5f7fb;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>

    <!-- Barre de navigation -->
    <?php include './Views/partials/navbar.php'; ?>

    <div class="container py-5">
        
        <!-- Messages flash de succès ou d'erreur -->
        <?php if(isset($_SESSION["success"])): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION["success"] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION["success"]); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION["error"])): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $_SESSION["error"] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION["error"]); ?>
        <?php endif; ?>

        <!-- En-tête de bienvenue -->
        <div class="bg-primary text-white p-4 rounded-4 shadow-sm mb-5">
            <h2 class="fw-bold mb-1">Espace Personnel</h2>
            <p class="mb-0 text-light opacity-75">Bienvenue dans votre espace, <?= htmlspecialchars($visiteur->nom) ?> ! Retrouvez ici vos informations et vos contributions.</p>
        </div>

        <div class="row g-4">
            
            <!-- Colonne de gauche : Mon Profil -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                    <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-person-fill text-primary me-2"></i> Mon Profil</h4>
                    <hr class="mb-4">
                    
                    <form action="index.php?action=updateProfilVisiteur" method="POST">
                        <div class="mb-3">
                            <label for="nom" class="form-label fw-semibold">Nom complet <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="nom" name="nom" value="<?= htmlspecialchars($visiteur->nom) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Adresse Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control rounded-3" id="email" name="email" value="<?= htmlspecialchars($visiteur->email) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="telephone" class="form-label fw-semibold">Numéro de téléphone</label>
                            <input type="tel" class="form-control rounded-3" id="telephone" name="telephone" value="<?= htmlspecialchars($visiteur->telephone ?? '') ?>" placeholder="Ex: 6xxxxxx">
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label fw-semibold">Âge</label>
                            <input type="number" class="form-control rounded-3" id="age" name="age" value="<?= htmlspecialchars($visiteur->age ?? '') ?>" placeholder="Ex: 25">
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary rounded-3 fw-bold shadow-sm">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Colonne de droite : Historique des avis -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white mb-4">
                    <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-chat-left-text-fill text-primary me-2"></i> Mes Avis</h4>
                    <hr class="mb-4">

                    <?php if(!empty($avis)): ?>
                        <?php foreach($avis as $av): ?>
                            <div class="card border border-light shadow-none p-3 rounded-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="fw-bold text-dark mb-0"><?= htmlspecialchars($av->nom_entreprise) ?></h5>
                                        <small class="text-muted">Publié le : <?= date('d/m/Y H:i', strtotime($av->date_commentaire)) ?></small>
                                    </div>
                                    <div class="text-warning">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star<?= $i <= $av->note ? '-fill' : '' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <p class="text-secondary small mb-3"><?= nl2br(htmlspecialchars($av->description)) ?></p>
                                
                                <div class="d-flex gap-2">
                                    <!-- Bouton d'édition d'avis -->
                                    <button class="btn btn-sm btn-outline-warning rounded-pill px-3" onclick="$('#editForm-<?= $av->id_commentaire ?>').toggleClass('d-none');">
                                        <i class="bi bi-pencil-fill me-1"></i> Modifier
                                    </button>
                                    <!-- Bouton de suppression d'avis -->
                                    <a href="index.php?action=supprimerCommentaire&id=<?= $av->id_commentaire ?>&source=dashboard" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Voulez-vous vraiment supprimer cet avis ?');">
                                        <i class="bi bi-trash-fill me-1"></i> Supprimer
                                    </a>
                                </div>

                                <!-- Formulaire d'édition masqué -->
                                <div id="editForm-<?= $av->id_commentaire ?>" class="mt-3 p-3 bg-light rounded-3 d-none">
                                    <form action="index.php?action=updateCommentaire" method="POST">
                                        <input type="hidden" name="id_commentaire" value="<?= $av->id_commentaire ?>">
                                        <input type="hidden" name="source" value="dashboard">
                                        <div class="mb-2">
                                            <label class="form-label fw-semibold small">Note</label>
                                            <select name="note" class="form-select form-select-sm rounded-3" required>
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <option value="<?= $i ?>" <?= $av->note == $i ? 'selected' : '' ?>><?= $i ?> étoile(s)</option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold small">Commentaire</label>
                                            <textarea name="description" class="form-control form-control-sm rounded-3" rows="3" required><?= htmlspecialchars($av->description) ?></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary rounded-3 fw-semibold">
                                            Sauvegarder
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light rounded-3" onclick="$('#editForm-<?= $av->id_commentaire ?>').addClass('d-none');">
                                            Annuler
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-light border border-light text-center py-4">
                            <i class="bi bi-chat-left-dots fs-1 text-muted mb-2 d-block"></i>
                            <p class="text-secondary small mb-0">Vous n'avez pas encore laissé de commentaires sur les entreprises.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Section Historique rapide -->
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                    <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-clock-history text-primary me-2"></i> Historique d'activité</h4>
                    <hr class="mb-4">
                    <ul class="list-group list-group-flush small">
                        <?php if(!empty($avis)): ?>
                            <li class="list-group-item px-0">
                                <i class="bi bi-chat-left text-success me-2"></i> Dernier avis laissé le <?= date('d/m/Y à H:i', strtotime($avis[0]->date_commentaire)) ?>
                            </li>
                        <?php endif; ?>
                        <li class="list-group-item px-0">
                            <i class="bi bi-person-check text-info me-2"></i> Compte actif en tant que Visiteur de l'annuaire WonderPro.
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Pied de page -->
    <?php include './Views/partials/footer.php'; ?>
</body>
</html>
