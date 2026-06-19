<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Annuaire Bafoussam</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.min.css">

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            min-height: 100vh;
            background: #f5f7fb;
            font-family: Arial, Helvetica, sans-serif;
            overflow-x: hidden;
        }

        /* SECTION PRINCIPALE */

        .login-container{
            min-height: 100vh;
        }

        /* PARTIE GAUCHE */

        .left-side{
            background: linear-gradient(rgba(13,110,253,0.9),
                        rgba(13,110,253,0.9)),
                        url('src/images/informatique.jpeg');

            background-size: cover;
            background-position: center;

            color: white;

            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;

            padding: 40px;
        }

        .left-side h1{
            font-size: 3rem;
            font-weight: bold;
        }

        .left-side p{
            font-size: 18px;
            margin-top: 20px;
            line-height: 1.7;
        }

        /* PARTIE DROITE */

        .right-side{
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .login-card{
            width: 100%;
            max-width: 450px;

            background: white;

            border-radius: 20px;

            padding: 40px;

            box-shadow: 0px 10px 30px rgba(0,0,0,0.08);
        }

        .login-card h2{
            font-weight: bold;
            margin-bottom: 10px;
        }

        .login-card p{
            color: gray;
            margin-bottom: 30px;
        }

        .form-control{
            height: 50px;
            border-radius: 10px;
        }

        .input-group-text{
            border-radius: 10px 0 0 10px;
        }

        .btn-login{
            height: 50px;
            border-radius: 10px;
            font-weight: bold;
        }

        .forgot-link{
            text-decoration: none;
            font-size: 14px;
        }

        .register-link{
            text-decoration: none;
            font-weight: bold;
        }

        .logo{
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* RESPONSIVE */

        @media(max-width: 992px){

            .left-side{
                display: none;
            }

            .right-side{
                padding: 20px;
            }
        }

        @media(max-width: 576px){
            .login-card{
                padding: 20px;
                border-radius: 16px;
            }
        }

    </style>
</head>
<body>
    <?php if(isset($_SESSION["success"])): ?>

<div class="container mt-3">

    <div class="alert alert-success alert-dismissible fade show">

        <?= $_SESSION["success"] ?>

        <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
        </button>

    </div>

</div>

<?php unset($_SESSION["success"]); ?>

<?php endif; ?>


<?php if(isset($_SESSION["error"])): ?>

<div class="container mt-3">

    <div class="alert alert-danger alert-dismissible fade show">

        <?= $_SESSION["error"] ?>

        <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
        </button>

    </div>

</div>

<?php unset($_SESSION["error"]); ?>

<?php endif; ?>

<div class="container-fluid">

    <div class="row login-container">

        <!-- PARTIE GAUCHE -->

        <div class="col-md-6 left-side">

            <div class="text-center">
                <div class="logo_img mb-3">
                    <img src="src/images/logo_simple_wonderpro.png" alt="Logo WonderPro" class="img-fluid shadow" style="width:250px; height:150px; object-fit:cover;">
                </div>
                <h1>
                    Heureux de vous revoir !
                </h1>

                <p>
                    Connectez-vous pour retrouver vos tableaux de bord, 
                    vos messages et toute l'actualité de votre espace WonderPro..
                </p>

            </div>

        </div>

        <!-- PARTIE DROITE -->

        <div class="col-md-6 right-side">

            <div class="login-card">

                <h2>
                    Connexion
                </h2>

                <p>
                    Accédez à votre espace personnel.
                </p>

                <!-- MESSAGE D'ERREUR -->

                <div class="alert alert-danger d-none" id="errorBox">
                    Veuillez remplir tous les champs.
                </div>

                <!-- FORMULAIRE -->

                <form action="index.php?action=connecter" method="POST" id="loginForm">

                    <!-- EMAIL -->

                    <div class="mb-3">

                        <label class="form-label">
                            Adresse email
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>

                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control"
                                   placeholder="Entrer votre email"
                                   value="<?= htmlspecialchars($_COOKIE['remember_email'] ?? '') ?>">

                        </div>

                    </div>

                    <!-- MOT DE PASSE -->

                    <div class="mb-3">

                        <label class="form-label">
                            Mot de passe
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>

                            <input type="password"
                                   name="mot_de_passe"
                                   id="password"
                                   class="form-control"
                                   placeholder="Entrer votre mot de passe">

                            <button type="button" class="btn btn-outline-secondary" id="togglePassword" tabindex="-1">
                                <i class="bi bi-eye"></i>
                            </button>

                        </div>

                    </div>

                    <!-- OPTIONS -->

                    <div class="d-flex justify-content-between mb-4">

                        <div class="form-check">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="remember"
                                   id="remember"
                                   <?= isset($_COOKIE['remember_token']) ? 'checked' : '' ?>>

                            <label class="form-check-label" for="remember">
                                Se souvenir de moi
                            </label>

                        </div>

                        <a href="index.php?action=motDePasseOublie" class="forgot-link">
                            Mot de passe oublié ?
                        </a>

                    </div>

                    <!-- BOUTON -->

                    <div class="d-grid mb-3">

                        <button type="submit"
                                class="btn btn-primary btn-login">

                            <i class="bi bi-box-arrow-in-right"></i>
                            Se connecter

                        </button>

                    </div>

                    <!-- INSCRIPTION -->

                    <div class="text-center">
                        Vous n'avez pas de compte ?
                        <a href="index.php?action=inscription"
                           class="register-link">
                            Créer un compte
                        </a>
                    </div>
                    <div class="mt-4">
                        <a href="index.php?action=accueil" class="btn btn-sm btn-outline-primary rounded-3">
                            <i class="bi bi-house-fill me-2"></i> Retour à l'accueil
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>
    


    
</div>

<!-- JQuery -->

<script src="src/bootstrap-5.3.8/js/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->

<script src="src/bootstrap-5.3.8/js/bootstrap.bundle.min.js"></script>

<script>

    // AFFICHER / MASQUER MOT DE PASSE

    $("#togglePassword").click(function(){

        let passwordField = $("#password");

        let type = passwordField.attr("type");

        if(type === "password"){

            passwordField.attr("type", "text");

            $(this).html('<i class="bi bi-eye-slash"></i>');

        }else{

            passwordField.attr("type", "password");

            $(this).html('<i class="bi bi-eye"></i>');

        }

    });

    // VALIDATION FORMULAIRE

    $("#loginForm").submit(function(e){

        let email = $("#email").val().trim();

        let password = $("#password").val().trim();

        if(email === "" || password === ""){

            e.preventDefault();

            $("#errorBox")
                .removeClass("d-none")
                .hide()
                .fadeIn();

        }

    });

</script>
</body>
</html>