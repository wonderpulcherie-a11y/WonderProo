<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Abonnements WonderPro</title>

<link href="src/bootstrap-5.3.8/css/bootstrap.min.css" rel="stylesheet">
<link href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    background:#f5f7fa;
}

.hero{
    background:linear-gradient(135deg,#0d6efd,#4f46e5);
    color:white;
    padding:60px 20px;
    text-align:center;
}

.pricing-card{
    border:none;
    border-radius:20px;
    transition:0.3s;
}

.pricing-card:hover{
    transform:translateY(-10px);
}

.recommended{
    border:3px solid #0d6efd;
}

.price{
    font-size:45px;
    font-weight:bold;
}

.badge-popular{
    position:absolute;
    top:-12px;
    right:20px;
}

</style>

</head>
<body>

<div class="hero">
    <div class="container">
        <div class="text-start mb-4">
            <a href="index.php?action=dashboard" class="btn btn-light btn-sm rounded-pill shadow-sm">
                &larr; Retour
            </a>
        </div>
        <h1>Limite d'essai atteinte</h1>

        <p class="lead">
            Vous avez déjà publié votre annonce gratuite.
            Choisissez un abonnement pour continuer à développer votre visibilité.
        </p>
    </div>
</div>

<div class="container py-5">

    <div class="row g-4">

        <!-- STANDARD -->

        <div class="col-md-4">

            <div class="card pricing-card shadow h-100">

                <div class="card-body text-center">
                    <h3>STANDARD</h3>
                    <div class="price">
                        5 000
                    </div>
                    <p>FCFA</p>
                    <hr>
                    <ul class="list-unstyled">
                        <li>✓ 3 mois</li>
                        <li>✓ Annonces illimitées</li>
                        <li>✓ Profil entreprise</li>
                    </ul>
                    <a
                        href="index.php?action=souscrire&id=STANDARD"
                        class="btn btn-primary w-100">
                        Choisir
                    </a>
                </div>
            </div>
        </div>

        <!-- VIP -->

        <div class="col-md-4">

            <div class="card pricing-card recommended shadow h-100 position-relative">

                <span class="badge bg-danger badge-popular">
                    Recommandé
                </span>

                <div class="card-body text-center">

                    <h3>VIP</h3>

                    <div class="price">
                        9 000
                    </div>

                    <p>FCFA</p>

                    <hr>

                    <ul class="list-unstyled">

                        <li>✓ 6 mois</li>
                        <li>✓ Annonces illimitées</li>
                        <li>✓ Mise en avant</li>

                    </ul>

                    <a
                        href="index.php?action=souscrire&id=VIP"
                        class="btn btn-success w-100">

                        Choisir

                    </a>

                </div>

            </div>

        </div>

        <!-- VVIP -->

        <div class="col-md-4">

            <div class="card pricing-card shadow h-100">

                <div class="card-body text-center">

                    <h3>VVIP</h3>

                    <div class="price">
                        15 000
                    </div>

                    <p>FCFA</p>

                    <hr>

                    <ul class="list-unstyled">

                        <li>✓ 1 an</li>
                        <li>✓ Annonces illimitées</li>
                        <li>✓ Priorité maximale</li>

                    </ul>

                    <a
                        href="index.php?action=souscrire&id=VVIP"
                        class="btn btn-dark w-100">

                        Choisir

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>