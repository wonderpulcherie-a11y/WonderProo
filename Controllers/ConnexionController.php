<?php

require_once "./Models/UtilisateurModel.php";
require_once "./Models/EntrepriseModel.php";
require_once "./Models/VisiteurModel.php";

class ConnexionController
{
    private $utilisateurModel;
    private $entrepriseModel;
    private $visiteurModel;

    public function __construct()
    {
        $this->utilisateurModel = new Utilisateur();
        $this->entrepriseModel = new Entreprise();
        $this->visiteurModel = new Visiteur();
    }

    /**
     * Tente une reconnexion automatique via le cookie "Se souvenir de moi"
     */
    public static function tenterAutoConnexion()
    {
        if (isset($_SESSION["id_utilisateur"]) || empty($_COOKIE["remember_token"])) {
            return;
        }

        $controller = new self();
        $utilisateur = $controller->utilisateurModel->trouverParRememberToken($_COOKIE["remember_token"]);

        if (!$utilisateur) {
            setcookie("remember_token", "", time() - 3600, "/");
            return;
        }

        $controller->creerSession($utilisateur);
    }

    public function connecter()
    {
        $email = trim($_POST["email"] ?? "");
        $motDePasse = $_POST["mot_de_passe"] ?? "";
        $remember = isset($_POST["remember"]);

        if (empty($email) || empty($motDePasse)) {
            $_SESSION["error"] = "Veuillez remplir tous les champs.";
            header("Location: index.php?action=connexion");
            exit;
        }

        $utilisateur = $this->utilisateurModel->trouverParEmail($email);

        if (!$utilisateur || !password_verify($motDePasse, $utilisateur->mot_de_passe)) {
            $_SESSION["error"] = "Email ou mot de passe incorrect.";
            header("Location: index.php?action=connexion");
            exit;
        }

        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $this->utilisateurModel->updateRememberToken($utilisateur->id_utilisateur, $token);
            setcookie("remember_token", $token, time() + 86400 * 30, "/");
            setcookie("remember_email", $email, time() + 86400 * 30, "/");
        } else {
            $this->utilisateurModel->clearRememberToken($utilisateur->id_utilisateur);
            setcookie("remember_token", "", time() - 3600, "/");
            setcookie("remember_email", "", time() - 3600, "/");
        }

        $this->creerSession($utilisateur);
        $_SESSION["success"] = "Connexion réussie.";
        $this->redirigerSelonType($utilisateur->type_utilisateur);
    }

    /**
     * Affiche le formulaire de mot de passe oublié
     */
    public function afficherMotDePasseOublie()
    {
        require_once "./Views/mot_de_passe_oublie.php";
    }

    /**
     * Traite la demande de réinitialisation du mot de passe
     */
    public function traiterMotDePasseOublie()
    {
        $email = trim($_POST["email"] ?? "");

        if (empty($email)) {
            $_SESSION["error"] = "Veuillez saisir votre adresse email.";
            header("Location: index.php?action=motDePasseOublie");
            exit;
        }

        $utilisateur = $this->utilisateurModel->trouverParEmail($email);

        if ($utilisateur) {
            $token = bin2hex(random_bytes(32));
            $expires = date("Y-m-d H:i:s", time() + 3600);
            $this->utilisateurModel->definirResetToken($utilisateur->id_utilisateur, $token, $expires);

            $_SESSION["success"] = "Un lien de réinitialisation a été généré. Vous pouvez maintenant définir un nouveau mot de passe.";
            header("Location: index.php?action=reinitialiserMotDePasse&token=" . urlencode($token));
            exit;
        }

        $_SESSION["success"] = "Si cet email existe dans notre système, un lien de réinitialisation a été envoyé.";
        header("Location: index.php?action=connexion");
        exit;
    }

    /**
     * Affiche le formulaire de nouveau mot de passe
     */
    public function afficherReinitialisation()
    {
        $token = $_GET["token"] ?? "";

        if (empty($token) || !$this->utilisateurModel->trouverParResetToken($token)) {
            $_SESSION["error"] = "Lien de réinitialisation invalide ou expiré.";
            header("Location: index.php?action=motDePasseOublie");
            exit;
        }

        require_once "./Views/reinitialiser_mot_de_passe.php";
    }

    /**
     * Enregistre le nouveau mot de passe
     */
    public function traiterReinitialisation()
    {
        $token = $_POST["token"] ?? "";
        $motDePasse = $_POST["mot_de_passe"] ?? "";
        $confirmation = $_POST["confirmation"] ?? "";

        if (strlen($motDePasse) < 6) {
            $_SESSION["error"] = "Le mot de passe doit contenir au moins 6 caractères.";
            header("Location: index.php?action=reinitialiserMotDePasse&token=" . urlencode($token));
            exit;
        }

        if ($motDePasse !== $confirmation) {
            $_SESSION["error"] = "Les mots de passe ne correspondent pas.";
            header("Location: index.php?action=reinitialiserMotDePasse&token=" . urlencode($token));
            exit;
        }

        $utilisateur = $this->utilisateurModel->trouverParResetToken($token);

        if (!$utilisateur) {
            $_SESSION["error"] = "Lien de réinitialisation invalide ou expiré.";
            header("Location: index.php?action=motDePasseOublie");
            exit;
        }

        $hash = password_hash($motDePasse, PASSWORD_DEFAULT);
        $this->utilisateurModel->reinitialiserMotDePasse($utilisateur->id_utilisateur, $hash);

        $_SESSION["success"] = "Votre mot de passe a été réinitialisé. Vous pouvez vous connecter.";
        header("Location: index.php?action=connexion");
        exit;
    }

    private function creerSession($utilisateur)
    {
        session_regenerate_id(true);

        $_SESSION["id_utilisateur"] = $utilisateur->id_utilisateur;
        $_SESSION["nom"] = $utilisateur->nom;
        $_SESSION["type"] = $utilisateur->type_utilisateur;

        if ($utilisateur->type_utilisateur == "Entreprise") {
            $entreprise = $this->entrepriseModel->trouverParUtilisateur($utilisateur->id_utilisateur);
            $_SESSION["id_entreprise"] = $entreprise->id_entreprise;
        }

        if ($utilisateur->type_utilisateur == "Visiteur") {
            $visiteur = $this->visiteurModel->trouverParUtilisateur($utilisateur->id_utilisateur);
            $_SESSION["id_visiteur"] = $visiteur->id_visiteur;
        }
    }

    private function redirigerSelonType($type)
    {
        if ($type == "Entreprise") {
            header("Location: index.php?action=dashboardEntreprise");
            exit;
        }

        if ($type == "Admin") {
            header("Location: index.php?action=dashboardAdmin");
            exit;
        }

        header("Location: index.php?action=accueil");
        exit;
    }

    public function deconnexion()
    {
        if (isset($_SESSION["id_utilisateur"])) {
            $this->utilisateurModel->clearRememberToken($_SESSION["id_utilisateur"]);
        }

        setcookie("remember_token", "", time() - 3600, "/");

        session_destroy();
        session_start();
        $_SESSION["success"] = "Vous avez été déconnecté avec succès.";

        header("Location: index.php?action=accueil");
        exit;
    }
}
