<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - WonderPro</title>
    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <style>
        body { min-height: 100vh; background: #f5f7fb; display: flex; align-items: center; }
        .auth-card { max-width: 450px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card auth-card border-0 p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-key-fill text-primary fs-1"></i>
                    <h2 class="fw-bold mt-2">Mot de passe oublié</h2>
                    <p class="text-muted">Saisissez votre email pour réinitialiser votre mot de passe.</p>
                </div>

                <?php if (isset($_SESSION["error"])): ?>
                    <div class="alert alert-danger"><?= $_SESSION["error"] ?></div>
                    <?php unset($_SESSION["error"]); ?>
                <?php endif; ?>

                <form action="index.php?action=traiterMotDePasseOublie" method="POST">
                    <div class="mb-4">
                        <label class="form-label">Adresse email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="votre@email.com" required>
                        </div>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-lg rounded-3">
                            Envoyer le lien de réinitialisation
                        </button>
                    </div>
                    <div class="text-center mb-3">
                        <a href="index.php?action=connexion" class="text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i> Retour à la connexion
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="index.php?action=accueil" class="text-decoration-none">
                            <i class="bi bi-house-fill me-1"></i> Retour à l'accueil
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
