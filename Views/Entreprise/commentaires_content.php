<?php
if(!isset($entreprise)) {
    die("Entreprise introuvable");
}
$commentaires = $commentaires ?? [];
$moyenne = $moyenne ?? 0;
$totalAvis = $totalAvis ?? 0;
?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark">Commentaires reçus</h2>
            <p class="text-muted">Répondez aux avis laissés par vos visiteurs et suivez la satisfaction client.</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-warning text-dark py-2 px-3">Note moyenne : <?= number_format($moyenne, 1) ?>/5</span>
            <span class="badge bg-primary py-2 px-3"><?= intval($totalAvis) ?> avis</span>
        </div>
    </div>

    <?php if(!empty($commentaires)): ?>
        <div class="row g-4">
            <?php foreach($commentaires as $commentaire): ?>
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">Avis de <?= htmlspecialchars(($commentaire->nom ?? '') . ' ' . ($commentaire->prenom ?? '')) ?></h5>
                                <div class="text-warning small">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star<?= $i <= $commentaire->note ? '-fill' : '' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <small class="text-muted"><?= date('d/m/Y H:i', strtotime($commentaire->date_commentaire)) ?></small>
                        </div>

                        <p class="text-secondary mb-3"><?= nl2br(htmlspecialchars($commentaire->description)) ?></p>

                        <?php if(!empty($commentaire->reponse)): ?>
                            <div class="border-start border-4 border-primary ps-3 mb-3">
                                <div class="small text-uppercase text-muted mb-1">Votre réponse</div>
                                <p class="mb-0 text-dark"><?= nl2br(htmlspecialchars($commentaire->reponse)) ?></p>
                                <?php if(!empty($commentaire->reponse_date)): ?>
                                    <small class="text-muted">Répondu le <?= date('d/m/Y H:i', strtotime($commentaire->reponse_date)) ?></small>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <div class="bg-light rounded-4 p-3">
                            <form action="index.php?action=repondreCommentaire" method="POST">
                                <input type="hidden" name="id_commentaire" value="<?= htmlspecialchars($commentaire->id_commentaire) ?>">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Répondre à ce commentaire</label>
                                    <textarea name="reponse" class="form-control rounded-3" rows="4" required><?= htmlspecialchars($commentaire->reponse ?? '') ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary rounded-pill">
                                    <i class="bi bi-reply-fill me-2"></i> Enregistrer la réponse
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info border-0 rounded-4 p-4">Aucun commentaire reçu pour le moment. Vos visiteurs pourront donner leur avis dès que vous aurez des annonces publiées.</div>
    <?php endif; ?>
</div>
