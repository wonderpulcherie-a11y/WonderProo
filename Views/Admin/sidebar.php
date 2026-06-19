<?php
$currentAction = $_GET['action'] ?? 'dashboardAdmin';
function isActive($action, $current) {
    return $action === $current ? 'active' : '';
}
?>
<div class="sidebar">
    <div class="brand">
        <i class="bi bi-shield-lock-fill"></i>
        <span>Admin WonderPro</span>
    </div>
    <nav class="menu">
        <a class="menu-item <?= isActive('dashboardAdmin', $currentAction) ?>" href="index.php?action=dashboardAdmin">
            <i class="bi bi-speedometer2"></i><span>Dashboard</span>
        </a>
        <a class="menu-item <?= isActive('demandesAdmin', $currentAction) ?>" href="index.php?action=demandesAdmin">
            <i class="bi bi-person-lines-fill"></i><span>Demandes</span>
        </a>
        <a class="menu-item <?= isActive('toutesEntreprises', $currentAction) ?>" href="index.php?action=toutesEntreprises">
            <i class="bi bi-building"></i><span>Entreprises</span>
        </a>
        <a class="menu-item <?= isActive('paiementsAdmin', $currentAction) ?>" href="index.php?action=paiementsAdmin">
            <i class="bi bi-wallet2"></i><span>Paiements</span>
        </a>
        <a class="menu-item <?= isActive('domainesAdmin', $currentAction) ?>" href="index.php?action=domainesAdmin">
            <i class="bi bi-diagram-3"></i><span>Domaines</span>
        </a>
        <a class="menu-item <?= isActive('servicesAdmin', $currentAction) ?>" href="index.php?action=servicesAdmin">
            <i class="bi bi-tools"></i><span>Services</span>
        </a>
    </nav>
    <div class="logout">
        <a href="index.php?action=logout">
            <i class="bi bi-box-arrow-right"></i><span>Déconnexion</span>
        </a>
    </div>
</div>
