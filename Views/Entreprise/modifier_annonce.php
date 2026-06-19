<?php

if(!isset($annonce)) {
    die("Annonce introuvable");
}

?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h3 class="fw-bold mb-1">Modifier l'annonce</h3>
                            <p class="text-muted mb-0">Actualisez les informations relatives à cette publication.</p>
                        </div>
                        <a href="index.php?action=mesAnnonces" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Retour aux annonces
                        </a>
                    </div>

                    <form method="POST" action="index.php?action=updateAnnonce" enctype="multipart/form-data">
                        <input type="hidden" name="id_annonce" value="<?= htmlspecialchars($annonce->id_annonce) ?>">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Titre</label>
                            <input type="text" name="titre" class="form-control rounded-3" value="<?= htmlspecialchars($annonce->titre) ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Contenu</label>
                            <textarea name="contenu" class="form-control rounded-3" rows="6" required><?= htmlspecialchars($annonce->contenu) ?></textarea>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Date début</label>
                                <input type="date" name="date_debut" class="form-control rounded-3" value="<?= htmlspecialchars($annonce->date_debut) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Date fin</label>
                                <input type="date" name="date_fin" class="form-control rounded-3" value="<?= htmlspecialchars($annonce->date_fin) ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Image actuelle</label>
                            <div class="border rounded-4 p-3 bg-light">
                                <img src="<?= htmlspecialchars($annonce->image) ?>" alt="Image annonce" class="img-fluid rounded-3" style="max-height: 260px; object-fit: cover;">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Modifier l'image</label>
                            <input type="file" name="image" class="form-control rounded-3">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php?action=mesAnnonces" class="btn btn-outline-secondary rounded-3">Annuler</a>
                            <button type="submit" class="btn btn-primary rounded-3">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>