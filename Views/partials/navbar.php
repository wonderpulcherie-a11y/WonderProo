<nav class="col-md-12 bg-white shadow-sm py-2">
            <div class="row align-items-center px-4 w-100">
                
                <div class="col-md-3 d-flex align-items-center">
                    <a href="index.php?action=accueil" class="text-decoration-none d-flex align-items-center">
                        <b class="fs-4 d-flex align-items-center">
                            <img src="src/images/logo_simple_wonderpro.png" alt="" style="height: 30px;">
                            <span class="text-primary">Wonder</span><span class="text-dark">Pro</span>
                        </b>
                    </a>
                </div>
                
                <div class="col-md-5"></div>
              
                <?php 
                // Vérifie si l'utilisateur est connecté pour adapter la navbar
                if(isset($_SESSION["id_utilisateur"])): 
                    $role = $_SESSION["type"] ?? "";
                    $dashboardLink = "index.php?action=accueil";
                    $btnText = "Mon Espace";
                    
                    if($role == "Admin") {
                        $dashboardLink = "index.php?action=dashboardAdmin";
                        $btnText = "Panel Admin";
                    } elseif($role == "Entreprise") {
                        $dashboardLink = "index.php?action=dashboardEntreprise";
                        $btnText = "Mon Dashboard";
                    } elseif($role == "Visiteur") {
                        $dashboardLink = "index.php?action=dashboardVisiteur";
                        $btnText = "Mon Espace";
                    }
                ?>
                    <!-- Menu utilisateur connecté -->
                    <div class="col-md-2 text-end">
                        <a href="<?= $dashboardLink ?>" class="btn btn-outline-primary w-100 py-2">
                            <i class="bi bi-speedometer2 me-1"></i> <?= $btnText ?>
                        </a>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="index.php?action=logout" class="btn btn-danger text-white w-100 py-2">
                            <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Liens pour les visiteurs non connectés -->
                    <div class="col-md-2 text-end">
                        <a href="index.php?action=connexion" class="btn btn-outline-primary w-100 py-2">Connexion</a>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="index.php?action=inscription" class="btn btn-primary text-white w-100 py-2">Inscription</a>
                    </div>
                <?php endif; ?>
                
            </div>
        </nav>