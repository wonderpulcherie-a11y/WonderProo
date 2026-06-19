<?php if (!isset($entreprise)) die("Entreprise introuvable"); ?>
<div class="container-fluid py-4">
    <h2 class="fw-bold text-dark mb-1">Notifications</h2>
    <p class="text-muted mb-4">Restez informé de l'état de votre compte et de votre abonnement.</p>

    <div class="row g-3">
        <?php foreach ($notifications as $notif): ?>
            <div class="col-12">
                <div class="alert alert-<?= $notif["type"] ?> border-0 rounded-4 shadow-sm d-flex align-items-start gap-3 mb-0">
                    <i class="bi bi-bell-fill fs-4"></i>
                    <div>
                        <h6 class="fw-bold mb-1"><?= htmlspecialchars($notif["titre"]) ?></h6>
                        <p class="mb-0 small"><?= htmlspecialchars($notif["message"]) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
