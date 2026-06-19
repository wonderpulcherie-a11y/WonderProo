<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon avis - WonderPro</title>
    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css">
</head>
<body class="bg-light">
<?php include './Views/partials/navbar.php'; ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h3 class="fw-bold mb-4">Modifier mon avis</h3>
                <form action="index.php?action=updateCommentaire" method="POST">
                    <input type="hidden" name="id_commentaire" value="<?= $commentaire->id_commentaire ?>">
                    <input type="hidden" name="source" value="<?= htmlspecialchars($_GET['source'] ?? 'details') ?>">
                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <select name="note" class="form-select" required>
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <option value="<?= $i ?>" <?= $commentaire->note == $i ? 'selected' : '' ?>><?= $i ?> étoile(s)</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Commentaire</label>
                        <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($commentaire->description) ?></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill">Enregistrer</button>
                        <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-pill">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
