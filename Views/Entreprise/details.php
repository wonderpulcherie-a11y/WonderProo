<?php
if(!$entreprise)
{
    die("Entreprise introuvable");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
<?= htmlspecialchars($entreprise->nom_entreprise) ?>
</title>

<link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
<link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css">

<style>

body{
    background:#f5f7fb;
}

.cover-card{
    border:none;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.cover-header{
    background:linear-gradient(
        135deg,
        #0d6efd,
        #0b5ed7
    );

    height:180px;
}

.logo-box{
    width:120px;
    height:120px;
    border-radius:50%;
    background:white;
    margin:auto;
    margin-top:-60px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:45px;
    font-weight:bold;
    color:#0d6efd;

    box-shadow:0 5px 15px rgba(0,0,0,.15);
}

.info-card{
    border:none;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

</style>

</head>
<body>

<div class="container py-5">
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

    <div class="card cover-card mb-4">

        <div class="cover-header"></div>

        <div class="card-body text-center">

            <div class="logo-box overflow-hidden d-flex align-items-center justify-content-center">

                <?php 
                // Affiche le logo de l'entreprise si défini, sinon affiche la première lettre
                if(!empty($entreprise->logo) && file_exists($entreprise->logo)): 
                ?>
                    <img src="<?= $entreprise->logo ?>" class="w-100 h-100" style="object-fit: cover;" alt="Logo">
                <?php else: ?>
                    <?= strtoupper(substr(
                        $entreprise->nom_entreprise,
                        0,
                        1
                    )) ?>
                <?php endif; ?>

            </div>

            <h2 class="mt-3 fw-bold">
                <?= htmlspecialchars(
                    $entreprise->nom_entreprise
                ) ?>
            </h2>

            <p class="text-muted">

                <i class="bi bi-geo-alt-fill"></i>

                <?= htmlspecialchars(
                    $entreprise->quartier
                ) ?>

            </p>

        </div>
        <div class="mb-2">

            <span class="text-warning">

                <?php
                $noteMoyenne =
                round(
                    $moyenne->moyenne ?? 0,
                    1
                );

                for($i=1; $i<=5; $i++)
                {
                    if($i <= round($noteMoyenne))
                    {
                        echo '<i class="bi bi-star-fill"></i>';
                    }
                    else
                    {
                        echo '<i class="bi bi-star"></i>';
                    }
                }
                ?>

            </span>

            <strong>
                <?= $noteMoyenne ?>/5
            </strong>

            (<?= $totalAvis->total ?? 0 ?> avis)

        </div>

    </div>

    <div class="row">

        <div class="col-lg-8">

            <div class="card info-card mb-4">

                <div class="card-body">

                    <h4 class="fw-bold mb-3">
                        À propos
                    </h4>
                    <h5 class="mt-4">
                        Domaines d'activité
                    </h5>

                    <?php foreach($domaines as $d): ?>

                        <span class="badge bg-primary">
                            <?= $d->nom_domaine ?>
                        </span>

                    <?php endforeach; ?>

                    <p>

                        <?= nl2br(
                            htmlspecialchars(
                                $entreprise->description
                            )
                        ) ?>

                    </p>
                    <h4 class="fw-bold mt-5">
                        Dernières annonces
                    </h4>

                    <?php if(!empty($annonces)): ?>

                        <?php foreach($annonces as $annonce): ?>

                            <div class="card mb-3">

                                <div class="card-body">

                                    <h5>
                                        <?= htmlspecialchars($annonce->titre) ?>
                                    </h5>

                                    <p>
                                        <?= htmlspecialchars($annonce->contenu) ?>
                                    </p>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <div class="alert alert-info">
                            Aucune annonce publiée.
                        </div>

                    <?php endif; ?>

<h4 class="fw-bold mt-5">
    Votre Avis
</h4>


<?php if(isset($_SESSION["id_visiteur"])): ?>

<form
method="POST"
action="index.php?action=publierCommentaire">

    <input
    type="hidden"
    name="id_entreprise"
    value="<?= $entreprise->id_entreprise ?>">

    <div class="mb-3">

        <label class="form-label">
            Votre note
        </label>

        <select
        name="note"
        class="form-select"
        required>

            <option value="">Choisir</option>
            <option value="1">1 étoile</option>
            <option value="2">2 étoiles</option>
            <option value="3">3 étoiles</option>
            <option value="4">4 étoiles</option>
            <option value="5">5 étoiles</option>

        </select>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Votre avis
        </label>

        <textarea
        name="description"
        class="form-control"
        rows="4"
        required></textarea>

    </div>

    <button
    type="submit"
    class="btn btn-primary">

        Publier mon avis

    </button>

</form>

<hr>

<h4>
    Avis des visiteurs
</h4>

<?php if(!empty($commentaires)): ?>

    <?php foreach($commentaires as $commentaire): ?>

        <div class="card mb-3">

            <div class="card-body">

                <div class="text-warning mb-2">

                    <?php for($i=1; $i<=5; $i++): ?>

                        <?php if($i <= $commentaire->note): ?>

                            <i class="bi bi-star-fill"></i>

                        <?php else: ?>

                            <i class="bi bi-star"></i>

                        <?php endif; ?>

                    <?php endfor; ?>

                </div>
<p>

    <span id="court<?= $commentaire->id_commentaire ?>">

        <?= htmlspecialchars(substr($commentaire->description,0,120)) ?>

        <?php if(strlen($commentaire->description) > 120): ?>

            ...

            <a
            href="#"
            onclick="
                document.getElementById('court<?= $commentaire->id_commentaire ?>').style.display='none';
                document.getElementById('long<?= $commentaire->id_commentaire ?>').style.display='inline';
                return false;
            ">
                Lire la suite
            </a>

        <?php endif; ?>

    </span>

    <span
    id="long<?= $commentaire->id_commentaire ?>"
    style="display:none;">

        <?= nl2br(htmlspecialchars($commentaire->description)) ?>

        <a
        href="#"
        onclick="
            document.getElementById('long<?= $commentaire->id_commentaire ?>').style.display='none';
            document.getElementById('court<?= $commentaire->id_commentaire ?>').style.display='inline';
            return false;
        ">
            Réduire
        </a>

    </span>

</p>

                <?php if (!empty($commentaire->reponse)): ?>
                    <div class="border-start border-4 border-primary ps-3 mb-3">
                        <div class="small text-uppercase text-muted mb-1">Réponse de l'entreprise</div>
                        <p class="mb-1 text-dark"><?= nl2br(htmlspecialchars($commentaire->reponse)) ?></p>
                        <?php if (!empty($commentaire->reponse_date)): ?>
                            <small class="text-muted">Répondu le <?= date('d/m/Y H:i', strtotime($commentaire->reponse_date)) ?></small>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <small class="text-muted">

                    <?= $commentaire->date_commentaire ?>

                </small>

            </div>
            <?php if(
    isset($_SESSION["id_visiteur"])
    &&
    $_SESSION["id_visiteur"]
    ==
    $commentaire->id_visiteur
): ?>

<a
href="#"
class="btn btn-warning btn-sm"
onclick="document.getElementById('edit<?= $commentaire->id_commentaire ?>').style.display='block'; return false;">
    Modifier
</a>
<div
id="edit<?= $commentaire->id_commentaire ?>"
style="display:none;"
class="mt-3">

    <form
    method="POST"
    action="index.php?action=updateCommentaire">

        <input
        type="hidden"
        name="id_commentaire"
        value="<?= $commentaire->id_commentaire ?>">

        <div class="mb-2">

            <textarea
            name="description"
            class="form-control"
            rows="3"
            required><?= htmlspecialchars($commentaire->description) ?></textarea>

        </div>

        <div class="mb-2">

            <select
            name="note"
            class="form-select"
            required>

                <?php for($i=1; $i<=5; $i++): ?>

                    <option
                    value="<?= $i ?>"
                    <?= $commentaire->note == $i ? "selected" : "" ?>>

                        <?= $i ?> étoile(s)

                    </option>

                <?php endfor; ?>

            </select>

        </div>

        <button
        type="submit"
        class="btn btn-primary btn-sm">

            Enregistrer

        </button>

    </form>

</div>

<a
href="index.php?action=supprimerCommentaire&id=<?= $commentaire->id_commentaire ?>"
class="btn btn-sm btn-danger"
onclick="return confirm('Supprimer cet avis ?')">

    Supprimer

</a>

<?php endif; ?>

        </div>

    <?php endforeach; ?>
    <a
href="index.php?action=tousCommentaires&id=<?= $entreprise->id_entreprise ?>"
class="btn btn-outline-primary">

    Voir tous les avis

</a>

<?php else: ?>

    <div class="alert alert-secondary">

        Aucun avis pour le moment.

    </div>


<?php endif; ?>

<?php else: ?>

<div class="alert alert-info">

    Connectez-vous pour laisser un avis.

    <a href="index.php?action=connexion">
        Se connecter
    </a>

</div>

<?php endif; ?>
                </div>
                

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card info-card">

                <div class="card-body">

                    <h4 class="fw-bold mb-4">
                        Contact
                    </h4>

                    <p>
                        <i class="bi bi-telephone-fill text-primary"></i>
                        <?= htmlspecialchars(
                            $entreprise->telephone
                        ) ?>
                    </p>

                    <p>
                        <i class="bi bi-envelope-fill text-primary"></i>
                        <?= htmlspecialchars(
                            $entreprise->email
                        ) ?>
                    </p>

                    <p>
                        <i class="bi bi-globe text-primary"></i>

                        <a
                        href="<?= htmlspecialchars($entreprise->site_web) ?>"
                        target="_blank">

                        <?= htmlspecialchars(
                            $entreprise->site_web
                        ) ?>

                        </a>
                    </p>

                    <div class="d-grid gap-2 mt-4">

                        <a
                        href="mailto:<?= $entreprise->email ?>"
                        class="btn btn-primary">

                            <i class="bi bi-envelope"></i>
                            Contacter

                        </a>

                        <a
                        href="<?= $entreprise->site_web ?>"
                        target="_blank"
                        class="btn btn-outline-primary">

                            <i class="bi bi-globe"></i>
                            Site Web

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>