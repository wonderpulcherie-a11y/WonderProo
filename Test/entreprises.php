<?php
// =========================================================================
// RÉCUPÉRATION ET SÉCURISATION DES DONNÉES DE RECHERCHE
// =========================================================================

// 1. On vérifie si l'utilisateur a tapé un mot-clé dans le champ "motcle".
// Si oui, on le stocke. Si non, on laisse la variable vide ''.
// htmlspecialchars() sert à bloquer les attaques de scripts malveillants.
$motcle_recherche = isset($_GET['motcle']) ? htmlspecialchars(trim($_GET['motcle'])) : '';

// 2. On fait pareil pour le quartier sélectionné dans la liste déroulante
$quartier_recherche = isset($_GET['quartier']) ? htmlspecialchars($_GET['quartier']) : '';

// 3. Et pareil pour le domaine d'activité sélectionné
$domaine_recherche = isset($_GET['domaine']) ? htmlspecialchars($_GET['domaine']) : '';


// =========================================================================
// SÉCURITÉ DE TEST : ÉTAPE PAR ÉTAPE
// =========================================================================
// Les 3 lignes ci-dessous (var_dump) vont nous servir à vérifier sur ton écran 
// que PHP reçoit bien tes choix en direct. On les supprimera juste après !
echo "<div class='alert alert-warning m-0 rounded-0 small' style='z-index: 9999; position: relative;'>";
echo "<strong>Test PHP direct :</strong> ";
echo "Mot-clé saisi : '" . $motcle_recherche . "' | ";
echo "Quartier choisi : '" . $quartier_recherche . "' | ";
echo "Domaine choisi : '" . $domaine_recherche . "'";
echo "</div>";

// // ON INCLUT LE MODÈLE POUR QUE PHP CONNAISSE LA FONCTION
// require_once './Models/Domaine.php';
// // On appelle la fonction du modèle en lui passant les filtres récupérés dans l'URL
// $entreprises_trouvees = obtenirEntreprisesRecherche($motcle_recherche, $quartier_recherche, $domaine_recherche);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Toutes les entreprises - WonderPro</title>
    <link href="src/bootstrap-5.3.8/css/bootstrap.min.css" rel="stylesheet">
    <link href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; }
        
        /* Effet de survol fluide sur les cartes horizontales */
        .company-card { transition: transform 0.2s, box-shadow 0.2s; cursor: pointer; }
        .company-card:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.08)!important; }
        
        /* Style personnalisé pour la grande barre de recherche horizontale */
        .filter-horizontal-bar { background-color: #ffffff; border-radius: 15px; padding: 20px; }
        
        .custom-footer { background-color: #111622 !important; color: #ffffff !important; }
        .f-link { color: #cbd5e1 !important; text-decoration: none !important; display: block; transition: all 0.2s; }
        .f-link:hover { color: #0d6efd !important; padding-left: 4px; }
    </style>
</head>
<body>

    <?php include 'Views/partials/navbar.php'; ?>

    <div class="bg-primary text-white py-5 mb-4 shadow-sm">
        <div class="container text-center">
            <h1 class="fw-bold">Annuaire des Entreprises</h1>
            <p class="lead mb-0">Trouvez les meilleurs professionnels et établissements à Bafoussam</p>
        </div>
    </div>

    <main class="container mb-5">
        
        <div class="filter-horizontal-bar shadow-sm mb-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-funnel-fill text-primary me-2"></i>Rechercher et filtrer</h5>
            
            <form action="index.php" method="GET">
                <input type="hidden" name="page" value="entreprises">
                
                <div class="row g-3 align-items-end">
                    
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary small">Nom ou Mot-clé</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="motcle" class="form-control border-start-0" placeholder="Ex: Envol, Santé..." value="<?php echo isset($_GET['motcle']) ? htmlspecialchars($_GET['motcle']) : ''; ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary small">Quartier / Zone</label>
                        <select name="quartier" class="form-select">
                            <option value="">Tous les quartiers</option>
                            <option value="Tamdja" <?php echo (isset($_GET['quartier']) && $_GET['quartier'] == 'Tamdja') ? 'selected' : ''; ?>>Tamdja</option>
                            <option value="Akwa" <?php echo (isset($_GET['quartier']) && $_GET['quartier'] == 'Akwa') ? 'selected' : ''; ?>>Carrefour Akwa</option>
                            <option value="Banengo" <?php echo (isset($_GET['quartier']) && $_GET['quartier'] == 'Banengo') ? 'selected' : ''; ?>>Banengo</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary small">Domaine d'activité</label>
                        <select name="domaine" class="form-select">
                            <option value="">Tous les domaines</option>
                            <option value="Santé" <?php echo (isset($_GET['domaine']) && $_GET['domaine'] == 'Santé') ? 'selected' : ''; ?>>Santé</option>
                            <option value="Informatique" <?php echo (isset($_GET['domaine']) && $_GET['domaine'] == 'Informatique') ? 'selected' : ''; ?>>Informatique</option>
                            <option value="Commerce" <?php echo (isset($_GET['domaine']) && $_GET['domaine'] == 'Commerce') ? 'selected' : ''; ?>>Commerce</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill">
                            <i class="bi bi-sliders me-2"></i>Filtrer
                        </button>
                    </div>
                    
                </div>
            </form>
        </div>

        <section class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-3 shadow-sm">
                <span class="text-muted fw-medium">
                    <?php echo count($entreprises_trouvees); ?> entreprise(s) trouvée(s) à Bafoussam</span>
                <select class="form-select form-select-sm w-auto">
                    <option>Les mieux notées</option>
                    <option>Plus récentes</option>
                </select>
            </div>

            <div class="row row-cols-1 g-3">
                <div class="row row-cols-1 g-3">
    
    <?php if (!empty($entreprises_trouvees)): ?>
        
        <?php foreach ($entreprises_trouvees as $entreprise): ?>
            <div class="col">
                <div class="card company-card border-0 shadow-sm overflow-hidden bg-white">
                    <div class="row g-0 align-items-center">
                        
                        <div class="col-sm-2 d-flex justify-content-center py-4 bg-light">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 65px; height: 65px; min-width: 65px; font-size: 1.4rem;">
                                <?php echo strtoupper(substr($entreprise->nom_entreprise, 0, 1)); ?>
                            </div>
                        </div>
                        
                        <div class="col-sm-10">
                            <div class="card-body p-3">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1 fs-5"><?php echo htmlspecialchars($entreprise->nom_entreprise); ?></h5>
                                        
                                        <span class="badge bg-light text-primary border border-primary-subtle me-2">
                                            <?php echo htmlspecialchars($entreprise->nom_domain); // Vérifie si dans ta BD c'est 'nom_domaine' ou 'nom_domain' ?>
                                        </span>
                                        
                                        <span class="text-muted small">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?php echo htmlspecialchars($entreprise->quartier); ?>, Bafoussam
                                        </span>
                                    </div>
                                    <div>
                                        <a href="index.php?page=details&id=<?php echo $entreprise->id_entreprise; ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Voir le profil</a>
                                    </div>
                                </div>
                                
                                <p class="text-secondary small mb-0 mt-2">
                                    <?php echo htmlspecialchars($entreprise->description); ?>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="col-12 text-center py-5 bg-white rounded-3 shadow-sm">
            <i class="bi bi-exclamation-circle text-muted fs-1"></i>
            <p class="text-muted mt-2 mb-0">Aucune entreprise ne correspond à vos critères de recherche.</p>
        </div>
    <?php endif; ?>

</div>
            </div>
        </section>

    </main>

    <?php include 'Views/partials/footer.php'; ?>
</body>
</html>