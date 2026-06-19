<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - WonderPro</title>
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
                    <i class="bi bi-shield-lock-fill text-primary fs-1"></i>
                    <h2 class="fw-bold mt-2">Nouveau mot de passe</h2>
                    <p class="text-muted">Choisissez un mot de passe sécurisé pour votre compte.</p>
                </div>

                <?php if (isset($_SESSION["error"])): ?>
                    <div class="alert alert-danger"><?= $_SESSION["error"] ?></div>
                    <?php unset($_SESSION["error"]); ?>
                <?php endif; ?>

                <form action="index.php?action=traiterReinitialisation" method="POST">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($_GET["token"] ?? "") ?>">
                    <div class="mb-3">
                        <label class="form-label">Nouveau mot de passe</label>
                        <input type="password" name="mot_de_passe" class="form-control" minlength="6" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="confirmation" class="form-control" minlength="6" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-3">
                            Réinitialiser mon mot de passe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
