<style>
    .sidebar-partial {
        width: 250px;
        background: linear-gradient(180deg, #0d6efd, #0b5ed7);
        color: white;
        padding: 20px 15px;
        min-height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        z-index: 1000;
    }
    .sidebar-partial a {
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 4px;
        transition: 0.2s;
    }
    .sidebar-partial a:hover {
        background: rgba(255,255,255,0.15);
        color: #fff;
    }
    .sidebar-partial .company-logo,
    .sidebar-partial .company-initials {
        width: 70px;
        height: 70px;
        object-fit: cover;
    }
    .sidebar-partial .company-initials {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: bold;
    }
</style>

<div class="sidebar-partial">
    <div class="text-center py-3">
        <?php if (!empty($entreprise->logo) && file_exists($entreprise->logo)): ?>
            <img src="<?= $entreprise->logo ?>" class="company-logo rounded-circle shadow-sm mx-auto mb-2" alt="Logo">
        <?php else: ?>
            <div class="company-initials rounded-circle bg-white text-primary shadow-sm mx-auto mb-2">
                <?= strtoupper(substr($entreprise->nom_entreprise ?? 'W', 0, 1)) ?>
            </div>
        <?php endif; ?>
        <h6 class="fw-bold mb-1"><?= htmlspecialchars($entreprise->nom_entreprise) ?></h6>
        <?php if ($souscription): ?>
            <span class="badge bg-light text-primary"><?= htmlspecialchars($souscription->id_abonnement) ?></span>
        <?php endif; ?>
    </div>
    <hr class="border-light opacity-25">
    <nav>
        <a href="index.php?action=dashboardEntreprise"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="index.php?action=mesAnnonces"><i class="bi bi-megaphone"></i> Mes annonces</a>
        <a href="index.php?action=servicesEntreprise"><i class="bi bi-tools"></i> Mes services</a>
        <a href="index.php?action=commentairesEntreprise"><i class="bi bi-chat-left-text"></i> Commentaires</a>
        <a href="index.php?action=profilEntreprise"><i class="bi bi-building"></i> Mon profil</a>
        <a href="index.php?action=notifications"><i class="bi bi-bell"></i> Notifications</a>
        <hr class="border-light opacity-25">
        <a href="index.php?action=logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
    </nav>
</div>
