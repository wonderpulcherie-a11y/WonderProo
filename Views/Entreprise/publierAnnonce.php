<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Publier une annonce</title>

<link rel="stylesheet"
href="./src/bootstrap-5.3.8/css/bootstrap.min.css">

<link rel="stylesheet"
href="./src/bootstrap-icons-1.13.1/bootstrap-icons.css">

<style>

body{
    background:#f5f7fb;
}

.page-header{
    background:linear-gradient(
        135deg,
        #0d6efd,
        #0b5ed7
    );
    color:white;
    padding:50px 0;
}

.form-card{
    border:none;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.form-control{
    border-radius:12px;
}

textarea{
    resize:none;
}

</style>

</head>
<body>

<div class="page-header">

    <div class="container">

        <h2 class="fw-bold">
            <i class="bi bi-megaphone-fill"></i>
            Publier une annonce
        </h2>

        <p class="mb-0">
            Informez les visiteurs de vos offres,
            recrutements, promotions ou événements.
        </p>

    </div>

</div>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card form-card">

                <div class="card-body p-4">

                    <form method="POST" action="index.php?action=publierAnnonce" enctype="multipart/form-data">
                        <!-- <div class="mb-4">

                            <label class="form-label fw-bold">
                                Image de l'annonce
                            </label>

                            <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept="image/*"
                            required>

                        </div> -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                Titre de l'annonce
                            </label>
                            <input
                            type="text"
                            name="titre"
                            class="form-control"
                            placeholder="Exemple : Offre de stage en développement web"
                            required>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Description
                            </label>

                            <textarea
                            name="contenu"
                            rows="8"
                            class="form-control"
                            placeholder="Décrivez votre annonce..."
                            required></textarea>

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">
                                    Date de début
                                </label>

                                <input
                                type="date"
                                name="date_debut"
                                class="form-control"
                                required>

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">
                                    Date de fin
                                </label>

                                <input
                                type="date"
                                name="date_fin"
                                class="form-control"
                                required>

                            </div>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Image de l'annonce
                            </label>

                            <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept="image/*">

                            <small class="text-muted">
                                JPG, PNG ou WEBP
                            </small>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a
                            href="index.php?action=dashboardEntreprise"
                            class="btn btn-outline-secondary">

                                <i class="bi bi-arrow-left"></i>
                                Retour

                            </a>

                            <button
                            type="submit"
                            class="btn btn-primary px-4">

                                <i class="bi bi-send-fill"></i>
                                Publier

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>