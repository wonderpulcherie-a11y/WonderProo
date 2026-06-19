<?php

if(
    !isset($_SESSION["id_utilisateur"])
    ||
    $_SESSION["type"] != "Admin"
)
{
    header("Location:index.php?action=connexion");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css">
    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
    <script src="src/bootstrap-5.3.8/js/jquery-3.7.1.min.js"></script>
    <script src="src/bootstrap-5.3.8/js/bootstrap.bundle.min.js"></script>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            background: #f5f7fb;
            font-family: Arial, Helvetica, sans-serif;
        }

        /* SIDEBAR */

        .sidebar{
            width: 270px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, #0d6efd, #0b5ed7);
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px 15px;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }

        /* BRAND */
        .brand{
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: bold;
            padding: 10px 15px;
            margin-bottom: 25px;
        }

        .brand i{
            font-size: 22px;
        }

        /* MENU */
        .menu{
            flex: 1;
            overflow-y: auto;
        }

        .menu-item{
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 10px;
            text-decoration: none;
            color: rgba(255,255,255,0.85);
            transition: 0.25s;
        }

        .menu-item i{
            width: 20px;
            text-align: center;
        }

        .menu-item:hover{
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(5px);
        }

        /* ACTIVE ITEM */
        .menu-item.active{
            background: white;
            color: #0d6efd;
            font-weight: bold;
        }

        /* BADGE */
        .badge{
            margin-left: auto;
            background: rgba(255,255,255,0.25);
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 11px;
        }

        /* LOGOUT */
        .logout{
            margin-top: auto;
            padding-top: 10px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }

        .logout a{
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 10px;
            transition: 0.3s;
        }

        .logout a:hover{
            background: rgba(255,255,255,0.15);
        }

        /* MAIN CONTENT (garde ton ancien mais ajusté) */
        .main-content{
            margin-left: 270px;
            padding: 30px;
        }

        /* MOBILE */
        @media(max-width:768px){
            .sidebar{
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content{
                margin-left: 0;
            }
        }

        /* CARDS */

        .stat-card{
            border: none;
            border-radius: 20px;
            padding: 25px;
            color: white;
            transition: 0.3s;
        }

        .stat-card:hover{
            transform: translateY(-5px);
        }

        .bg-blue{
            background: #0d6efd;
        }

        .bg-green{
            background: #198754;
        }

        .bg-orange{
            background: #fd7e14;
        }

        .bg-red{
            background: #dc3545;
        }

        .stat-card i{
            font-size: 40px;
        }

        .stat-card h2{
            font-size: 35px;
            font-weight: bold;
        }

        /* TABLE */

        .table-container{
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.05);
        }

        .table thead{
            background: #0d6efd;
            color: white;
        }

        .badge-status{
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 13px;
        }

        /* NOTIFICATIONS */

        .notification-box{
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.05);
        }

        .notification-item{
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        /* RESPONSIVE */

        @media(max-width: 768px){

            .sidebar{
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content{
                margin-left: 0;
            }

        }
        /* TRANSITION GLOBAL */
        .sidebar,
        .main-content,
        .menu-item span,
        .brand span {
            transition: all 0.3s ease;
        }

        /* MODE COLLAPSED */
        .sidebar.collapsed{
            width: 80px;
        }

        /* CACHE TEXTES EN MODE COLLAPSE */
        .sidebar.collapsed .menu-item span,
        .sidebar.collapsed .brand span,
        .sidebar.collapsed .badge{
            display: none;
        }

        /* CENTRAGE ICÔNES */
        .sidebar.collapsed .menu-item{
            justify-content: center;
        }

        .sidebar.collapsed .brand{
            justify-content: center;
        }

        /* MAIN CONTENT ADAPTATIF */
        .main-content{
            margin-left: 270px;
        }

        .sidebar.collapsed ~ .main-content{
            margin-left: 80px;
        }

        /* TOOLTIP SIMPLE EN MODE COLLAPSE */
        .sidebar.collapsed .menu-item{
            position: relative;
        }

        .sidebar.collapsed .menu-item:hover::after{
            content: attr(data-title);
            position: absolute;
            left: 90px;
            background: #000;
            color: #fff;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
        }

        /* TRANSITION GLOBAL */
        .sidebar,
        .main-content,
        .menu-item span,
        .brand span {
            transition: all 0.3s ease;
        }

        /* MODE COLLAPSED */
        .sidebar.collapsed{
            width: 80px;
        }

        /* CACHE TEXTES EN MODE COLLAPSE */
        .sidebar.collapsed .menu-item span,
        .sidebar.collapsed .brand span,
        .sidebar.collapsed .badge{
            display: none;
        }

        /* CENTRAGE ICÔNES */
        .sidebar.collapsed .menu-item{
            justify-content: center;
        }

        .sidebar.collapsed .brand{
            justify-content: center;
        }

        /* MAIN CONTENT ADAPTATIF */
        .main-content{
            margin-left: 270px;
        }

        .sidebar.collapsed ~ .main-content{
            margin-left: 80px;
        }

        /* TOOLTIP SIMPLE EN MODE COLLAPSE */
        .sidebar.collapsed .menu-item{
            position: relative;
        }

        .sidebar.collapsed .menu-item:hover::after{
            content: attr(data-title);
            position: absolute;
            left: 90px;
            background: #000;
            color: #fff;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
        }

    </style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <div class="brand">
        <i class="bi bi-buildings"></i>
        <span>Admin Panel</span>
    </div>

    <div class="menu">

        <a class="menu-item active" href="index.php?action=dashboardAdmin" data-title="Dashboard">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <a class="menu-item" href="index.php?action=toutesEntreprises" data-title="Entreprises">
            <i class="bi bi-building"></i>
            <span>Entreprises</span>
            <span class="badge"><?= $nbEntreprises->total ?></span>
        </a>

        <a class="menu-item" href="index.php?action=demandesAdmin" data-title="Demandes">
            <i class="bi bi-file-earmark-text"></i>
            <span>Demandes</span>
            <span class="badge"><?= $nbDemandes->total ?></span>
        </a>

        <a class="menu-item" href="index.php?action=paiementsAdmin" data-title="Paiements">
            <i class="bi bi-credit-card"></i>
            <span>Paiements</span>
        </a>

        <a class="menu-item" href="index.php?action=domainesAdmin" data-title="Domaines">
            <i class="bi bi-grid"></i>
            <span>Domaines</span>
        </a>

        <a class="menu-item" href="index.php?action=servicesAdmin" data-title="Services">
            <i class="bi bi-tools"></i>
            <span>Services</span>
        </a>

    </div>

    <div class="logout" data-title="Deconnexion">
        <a href="index.php?action=logout">
            <i class="bi bi-box-arrow-right"></i>
            Déconnexion
        </a>
    </div>

</div>

<!-- MAIN CONTENT -->

<div class="main-content">
    <!-- TOPBAR -->
    <div class="topbar d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold">
                Tableau de bord administrateur
            </h3>
            <p class="text-muted">
                Bienvenue dans votre espace d'administration.
            </p>
        </div>
        <div>
            <a href="index.php?action=demandes" class="btn btn-primary">
                <i class="bi bi-bell"></i>
                Notifications
            </a>
        </div>

    </div>

    <?php if(isset($_SESSION["success"])): ?>

    <div class="alert alert-success alert-dismissible fade show">

        <?= $_SESSION["success"] ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    <?php unset($_SESSION["success"]); ?>

    <?php endif; ?>

    <!-- STATISTIQUES -->

    <div class="row g-4 mb-5">

        <div class="col-md-3">

            <div class="stat-card bg-blue">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h2>
                            <?= $nbEntreprises->total ?>
                        </h2>

                        <p>
                            Entreprises
                        </p>

                    </div>

                    <i class="bi bi-building"></i>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="stat-card bg-green">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h2>
                            <?= $nbDemandes->total ?>
                        </h2>

                        <p>
                            Demandes
                        </p>

                    </div>

                    <i class="bi bi-file-earmark-check"></i>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="stat-card bg-orange">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h2>
                            <?= $nbAbonnements->total ?? 0 ?>
                        </h2>

                        <p>
                            Abonnements actifs
                        </p>

                    </div>

                    <i class="bi bi-calendar2-check"></i>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="stat-card bg-red">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h2>
                            <?= number_format($revenus->total ?? 0, 0, ',', ' ') ?>
                        </h2>

                        <p>
                            Revenus (FCFA)
                        </p>

                    </div>

                    <i class="bi bi-cash-stack"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- TABLEAU DEMANDES -->

    <div class="row g-4">

        <!-- TABLE -->

        <div class="col-lg-9">

            <div class="table-container">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <h4 class="fw-bold">
                        Demandes récentes
                    </h4>

                    <button class="btn btn-primary">
                        <a
                        href="index.php?action=toutesEntreprises"
                        class="btn btn-primary">

                        Voir tout
                        </a>
                    </button>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                        <tr>
                            <th>Entreprise</th>
                            <th>Domaine</th>
                            <th>Date</th>
                            <!-- <th>RCCM</th> -->
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>

                        </thead>

                       <tbody>

                            <?php foreach($entreprises as $e): ?>
                            <tr>

                            <td>
                            <?= htmlspecialchars($e->nom_entreprise) ?>
                            </td>

                            <td>
                            <?= htmlspecialchars($e->domaines ?? '-') ?>
                            </td>

                            <td>
                            <?= date(
                                "d/m/Y",
                                strtotime($e->created_at)
                            ) ?>
                            </td>

                           

                            <td>

                                <?php if($e->statut == "en attente"): ?>

                                    <span class="badge bg-warning text-dark">
                                        En attente
                                    </span>

                                <?php elseif($e->statut == "valide"): ?>

                                    <span class="badge bg-success">
                                        Validée
                                    </span>

                                <?php elseif($e->statut == "rejete"): ?>

                                    <span class="badge bg-danger">
                                        Refusée
                                    </span>

                                <?php endif; ?>

                            </td>
                            <td>

                                <?php if($e->statut == "en attente"): ?>

                                <a
                                href="index.php?action=validerEntreprise&id=<?= $e->id_entreprise ?>"
                                class="btn btn-success btn-sm">
                                Valider
                                </a>

                                <a
                                href="index.php?action=refuserEntreprise&id=<?= $e->id_entreprise ?>"
                                class="btn btn-danger btn-sm">
                                Refuser
                                </a>

                                <?php else: ?>

                                <span class="text-muted">
                                Traité
                                </span>

                                <?php endif; ?>

                            </td>

                            </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- NOTIFICATIONS -->

        <div class="col-lg-3">

            <div class="notification-box">

                <h4 class="fw-bold mb-4">
                    Notifications
                </h4>

                <div class="notification-item">

                    <p class="mb-1 fw-bold">
                        Nouvelle demande reçue
                    </p>

                    <small class="text-muted">
                        Il y a 5 minutes
                    </small>

                </div>

                <div class="notification-item">

                    <p class="mb-1 fw-bold">
                        Paiement confirmé
                    </p>

                    <small class="text-muted">
                        Il y a 1 heure
                    </small>

                </div>

                <div class="notification-item">

                    <p class="mb-1 fw-bold">
                        Abonnement expiré
                    </p>

                    <small class="text-muted">
                        Aujourd'hui
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

    // Animation hover tableau

    $("table tbody tr").hover(function(){

        $(this).css("background","#f1f5ff");

    }, function(){

        $(this).css("background","white");

    });

     document.getElementById("toggleSidebar").addEventListener("click", function () {

     document.getElementById("sidebar").classList.toggle("collapsed");

 });

</script>
<?php if(isset($_SESSION["success"])): ?>
    <?php unset($_SESSION["success"]); ?>
<?php endif; ?>

<?php if(isset($_SESSION["error"])): ?>
    <?php unset($_SESSION["error"]); ?>
<?php endif; ?>
</body>
</html>