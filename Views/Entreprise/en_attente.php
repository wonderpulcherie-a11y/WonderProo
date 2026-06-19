<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande en attente</title>

    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-5">

    <div class="card shadow border-0">

        <div class="card-body text-center p-5">

            <h1 class="text-warning mb-4">
                ⏳ Demande en attente
            </h1>

            <p class="lead">
                Votre entreprise a bien été enregistrée.
            </p>

            <p>
                Votre demande est actuellement en cours de vérification
                par un administrateur.
            </p>

            <p>
                Après validation, vous pourrez accéder à votre
                tableau de bord et publier vos annonces.
            </p>

            <a href="index.php?action=logout"
               class="btn btn-primary mt-3">
                Déconnexion
            </a>

        </div>

    </div>

</div>
<?php if(isset($_SESSION["success"])): ?>
    <?php unset($_SESSION["success"]); ?>
<?php endif; ?>
</body>
</html>