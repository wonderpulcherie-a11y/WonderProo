<?php if(isset($_SESSION["success"])): ?>

<div class="alert alert-success">

    <?= $_SESSION["success"] ?>

</div>

<?php unset($_SESSION["success"]); ?>

<?php endif; ?>


<?php if(isset($_SESSION["error"])): ?>

<div class="alert alert-danger">

    <?= $_SESSION["error"] ?>

</div>

<?php unset($_SESSION["error"]); ?>

<?php endif; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuaire Entreprises Bafoussam</title>
    
    <script src="src/bootstrap-5.3.8/js/bootstrap.bundle.min.js"></script>
    <script src="src/bootstrap-5.3.8/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f5f7fb;
            font-family: Arial, Helvetica, sans-serif;
        }

        /* NAVBAR */
        .navbar {
            background: #0d6efd;
        }

        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: 500;
        }

        /* HERO SECTION */
        .hero {
            min-height: 90vh;
            display: flex;
            align-items: center;
            background: linear-gradient(rgba(13,110,253,0.85), rgba(0, 5, 14, 0.85)),
                        url('src/images/informatique.jpeg');
            background-size: cover;
            background-position: center;
            color: white;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        /* BARRE DE RECHERCHE OPTIMISÉE */
        .search-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px); /* Effet de flou moderne en arrière-plan */
            padding: 20px;
            border-radius: 20px;
            margin-top: 35px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .search-wrapper {
            background: white;
            border-radius: 12px;
            padding: 8px;
        }

        .search-input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Positionne l'icône à l'intérieur du champ textuel */
        .search-input-container i {
            position: absolute;
            left: 15px;
            color: #a0aec0;
            font-size: 1.2rem;
        }

        .search-input-container input {
            padding-left: 45px; /* Laisse de l'espace pour l'icône à gauche */
            border: none;
            background: transparent;
        }

        .search-input-container input:focus, .form-select-clean:focus {
            box-shadow: none;
            background: transparent;
        }

        .form-select-clean {
            border: none;
            border-left: 1px solid #e2e8f0; /* Petite barre de séparation interne */
            border-radius: 0;
            padding-left: 20px;
            color: #4a5568;
        }

        /* CARDS */
        .domain-card, .company-card {
            transition: 0.3s;
            border: none;
            border-radius: 15px;
        }

        .domain-card:hover, .company-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 5px 20px rgba(0,0,0,0.1);
        }

        .icon-box {
            width: 70px;
            height: 70px;
            background: #0d6efd;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: auto;
        }

        /* DESIGN DU FOOTER FLUIDE ET CONTRASTÉ */
        .custom-footer {
            background-color: #111622 !important; /* Fond sombre profond */
            color: #ffffff !important;
        }

        .footer-heading {
            color: #0d6efd !important; /* Titres bien bleus */
            font-size: 0.85rem !important;
            font-weight: 700 !important;
            letter-spacing: 1px;
        }

        .footer-description {
            color: #a0aec0 !important;
            line-height: 1.6;
        }

        /* Liens du footer */
        .f-link {
            color: #cbd5e1 !important; /* Gris clair très visible */
            text-decoration: none !important;
            font-size: 0.9rem;
            display: block;
            transition: all 0.2s ease-in-out;
        }

        .f-link:hover {
            color: #0d6efd !important; /* Devient bleu au survol */
            padding-left: 4px; /* Petit effet dynamique */
        }

        /* Boîte des icônes de réseaux sociaux */
        .social-box {
            color: #cbd5e1 !important;
            font-size: 1.2rem;
            text-decoration: none !important;
            transition: color 0.2s;
        }

        .social-box:hover {
            color: #0d6efd !important;
        }

        .annonce-card{
    transition:.3s;
    border:none;
    border-radius:15px;
    overflow:hidden;
    }

    .annonce-card:hover{
        transform:translateY(-5px);
        box-shadow:0 15px 35px rgba(0,0,0,.15);
    }

    .annonce-card img{
        height:220px;
        object-fit:cover;
    }

    .search-input-container {
        position: relative;
    }

    #search-suggestions {
        max-height: 320px;
        overflow-y: auto;
        background: white;
        border: 1px solid rgba(0,0,0,.12);
        border-radius: .75rem;
    }

    #search-suggestions .list-group-item {
        cursor: pointer;
    }

    #search-suggestions .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .annonce-card{
    transition:.3s;
    border-radius:15px;
    overflow:hidden;
    }

    .annonce-card:hover{
        transform:translateY(-5px);
        box-shadow:0 15px 30px rgba(0,0,0,.15)!important;
    }
    </style>
</head>
<body>
    <div class="overflow-hidden">
        <?php include './Views/partials/navbar.php'; ?>

        <section class="hero">
            <div class="container text-center">
                <h1 class="fs-1">Trouvez les meilleures entreprises à Bafoussam</h1>
                <p class="mt-3 fs-5 text-light">Santé, Informatique, Commerce, Education et plusieurs autres domaines.</p>
                
                <div class="search-box shadow-lg col-lg-11 mx-auto">
                    <form action="index.php" method="GET" autocomplete="off">
                        <input type="hidden" name="action" value="entreprises">
                        
                        <div class="row search-wrapper g-2 align-items-center">
                            <div class="col-lg-4 col-md-6 search-input-container position-relative">
                                <i class="bi bi-search"></i>
                                <input id="search-entreprise" type="text" name="motcle" class="form-control form-control-lg" placeholder="Une entreprise, un mot-clé...">
                                <div id="search-suggestions" class="list-group position-absolute w-100 mt-2 d-none" style="z-index: 1055;"></div>
                            </div>
                            
                            <div class="col-lg-3 col-md-3">
                                <select name="quartier" class="form-select form-select-lg form-select-clean">
                                    <option value="">Tous les quartiers</option>
                                    <option value="Tamdja">Tamdja</option>
                                    <option value="Akwa">Carrefour Akwa</option>
                                    <option value="Banengo">Banengo</option>
                                    <option value="Djeleng">Djeleng</option>
                                </select>
                            </div>
                            
                            <div class="col-lg-3 col-md-3">
                                <select name="domaine" class="form-select form-select-lg form-select-clean">
                                    <option value="">Tous les domaines</option>
                                    <?php if (!empty($tous_les_domaines_select)): ?>
                                        <?php foreach ($tous_les_domaines_select as $dom): ?>
                                            <option value="<?php echo htmlspecialchars($dom->nom_domaine); ?>">
                                                <?php echo htmlspecialchars($dom->nom_domaine); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            
                            <div class="col-lg-2 col-md-12 d-grid">
                                <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold shadow-sm" style="height: 52px;">
                                    Rechercher
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="container mt-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Domaines d'activités</h2>
                <p class="text-muted">Explorez les entreprises de Bafoussam selon leurs domaines</p>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <?php if (!empty($domaines)): ?>
                    <?php foreach ($domaines as $d): ?>
                        <div class="col">
                            <a href="index.php?action=entreprises&domaine=<?= urlencode($d->nom_domaine) ?>" class="text-decoration-none">
                                <div class="card domain-card p-4 text-center shadow-sm h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="icon-box mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #f0f7ff; border-radius: 50%;">
                                            <i class="bi bi-briefcase-fill text-primary fs-3"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-2"><?= htmlspecialchars($d->nom_domaine) ?></h5>
                                        <p class="text-muted small mb-0"><?= htmlspecialchars($d->description) ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Aucun domaine enregistré pour le moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <section class="container py-5">

            <div class="text-center mb-5">

                <h2 class="fw-bold">
                    Dernières annonces
                </h2>

                <p class="text-muted">
                    Promotions, offres et actualités
                </p>

            </div>

            <div class="row">

                <?php foreach($annonces as $annonce): ?>
                <div class="col-md-4 mb-4">

                    <a
                    href="index.php?action=voirAnnonce&id=<?= $annonce->id_annonce ?>&source=accueil"
                    class="text-decoration-none text-dark">

                        <div class="card shadow-sm h-100 annonce-card border-0">

                            <img
                            src="<?= !empty($annonce->image)
                                ? $annonce->image
                                : './public/images/default-annonce.jpg'; ?>"
                            class="card-img-top"
                            style="height:220px;object-fit:cover;"
                            alt="<?= htmlspecialchars($annonce->titre) ?>">

                            <div class="card-body d-flex flex-column">

                                <small class="text-primary fw-bold mb-2">
                                    <?= htmlspecialchars($annonce->nom_entreprise) ?>
                                </small>

                                <h5 class="card-title fw-bold">
                                    <?= htmlspecialchars($annonce->titre) ?>
                                </h5>

                                <p class="card-text text-muted flex-grow-1">

                                    <?= mb_strlen($annonce->contenu) > 120
                                        ? mb_substr(
                                            htmlspecialchars($annonce->contenu),
                                            0,
                                            120
                                        ) . "..."
                                        : htmlspecialchars($annonce->contenu)
                                    ?>

                                </p>

                                <div class="mt-auto">

                                    <small class="text-secondary">
                                        <i class="bi bi-calendar-event"></i>
                                        <?= date(
                                            "d/m/Y",
                                            strtotime($annonce->date_publication)
                                        ) ?>
                                    </small>

                                </div>

                            </div>

                        </div>

                    </a>

                </div>
                <?php endforeach; ?>

            </div>

        </section>

        <section class="container mt-5 pt-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Entreprises populaires</h2>
                <p class="text-muted">Découvrez les professionnels les plus consultés à Bafoussam</p>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <?php foreach($entreprises as $entreprise): ?>
                    <div class="col">
                        <div class="card company-card h-100 shadow-sm border-0 p-3 bg-white">
                            <div class="d-flex align-items-center mb-3">
                                <?php 
                                // Affiche le logo de l'entreprise si défini, sinon affiche la première lettre
                                if(!empty($entreprise->logo) && file_exists($entreprise->logo)): 
                                ?>
                                    <img src="<?= $entreprise->logo ?>" class="rounded-circle shadow-sm" style="width:55px;height:55px;object-fit:cover;" alt="Logo">
                                <?php else: ?>
                                    <div
                                        class="rounded-circle bg-primary text-white
                                            d-flex align-items-center justify-content-center fw-bold"
                                        style="width:55px;height:55px;font-size:22px;">
                                        <?= strtoupper(substr($entreprise->nom_entreprise,0,1)) ?>
                                    </div>
                                <?php endif; ?>
                                <div class="ms-3">
                                    <h5 class="fw-bold text-dark mb-0">
                                        <?= htmlspecialchars($entreprise->nom_entreprise) ?>
                                    </h5>
                                </div>
                            </div>
                            <div class="card-body py-2 px-0">
                                <p class="text-muted small mb-3">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    <?= htmlspecialchars($entreprise->quartier) ?>
                                </p>
                                <p class="text-secondary small mb-0">
                                    <?= htmlspecialchars($entreprise->description) ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-3 px-0 text-end">
                                <a
                                    href="index.php?action=detailsEntreprise&id=<?= $entreprise->id_entreprise ?>"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    Voir le profil
                                </a>
                            </div>
                        </div>
                    </div>
                
                <?php endforeach; ?>

            </div>
            <div class="text-center mt-5">
                <a href="index.php?action=entreprises" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm fw-medium fs-6">
                    Voir toutes les entreprises <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </section>
        <?php include './Views/partials/footer.php'; ?>

    </div>

    <script>
        $(document).ready(function(){
            $(".company-card").hover(function(){
                $(this).css("cursor", "pointer");
            });

            var timer = null;
            $("#search-entreprise").on("input", function() {
                var query = $(this).val().trim();
                var $suggestions = $("#search-suggestions");

                clearTimeout(timer);
                if (query.length < 2) {
                    $suggestions.addClass("d-none").empty();
                    return;
                }

                timer = setTimeout(function() {
                    fetch("index.php?action=autocompleteEntreprises&query=" + encodeURIComponent(query))
                        .then(function(response) { return response.json(); })
                        .then(function(data) {
                            $suggestions.empty();
                            if (!data || !data.length) {
                                $suggestions.addClass("d-none");
                                return;
                            }

                            data.forEach(function(item) {
                                var option = $('<button type="button" class="list-group-item list-group-item-action">')
                                    .text(item.nom_entreprise + ' – ' + item.quartier)
                                    .data('id', item.id_entreprise)
                                    .data('name', item.nom_entreprise);

                                option.on('click', function() {
                                    window.location.href = 'index.php?action=detailsEntreprise&id=' + encodeURIComponent($(this).data('id'));
                                });

                                $suggestions.append(option);
                            });
                            $suggestions.removeClass("d-none");
                        })
                        .catch(function() {
                            $suggestions.addClass("d-none");
                        });
                }, 250);
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('#search-entreprise, #search-suggestions').length) {
                    $('#search-suggestions').addClass('d-none');
                }
            });
        });
    </script>
</body>
</html>