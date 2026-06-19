<?php

require_once "./Models/VisiteurModel.php";
require_once "./Models/CommentaireModel.php";

/**
 * Contrôleur gérant les actions spécifiques des visiteurs (espace personnel, modification profil, historique d'avis)
 */
class VisiteurController
{
    private $visiteurModel;
    private $commentaireModel;

    /**
     * Constructeur - Initialisation des modèles
     */
    public function __construct()
    {
        $this->visiteurModel = new Visiteur();
        $this->commentaireModel = new Commentaire();
    }

    /**
     * Affiche l'espace personnel (dashboard) du visiteur connecté
     */
    public function dashboardVisiteur()
    {
        // Sécurité - Vérification que l'utilisateur est connecté et est un Visiteur
        if(!isset($_SESSION["id_visiteur"]) || $_SESSION["type"] != "Visiteur") {
            header("Location:index.php?action=connexion");
            exit();
        }

        $idVisiteur = $_SESSION["id_visiteur"];

        // Récupération des informations de profil et de l'historique des avis
        $visiteur = $this->visiteurModel->trouverParId($idVisiteur);
        $avis = $this->commentaireModel->getCommentairesVisiteur($idVisiteur);

        // Chargement de la vue du dashboard visiteur
        require_once "./Views/Visiteur/dashboard.php";
    }

    /**
     * Traite la mise à jour des informations de profil du visiteur
     */
    public function updateProfilVisiteur()
    {
        // Sécurité - Vérification que l'utilisateur est connecté et est un Visiteur
        if(!isset($_SESSION["id_visiteur"]) || $_SESSION["type"] != "Visiteur") {
            header("Location:index.php?action=connexion");
            exit();
        }

        $idVisiteur = $_SESSION["id_visiteur"];
        $visiteurObj = $this->visiteurModel->trouverParId($idVisiteur);
        $idUtilisateur = $visiteurObj->id_utilisateur;

        // Récupération des champs du formulaire
        $nom = trim($_POST["nom"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $telephone = trim($_POST["telephone"] ?? "");
        $age = intval($_POST["age"] ?? 0);

        if(empty($nom) || empty($email)) {
            $_SESSION["error"] = "Le nom et l'adresse email sont obligatoires.";
            header("Location:index.php?action=dashboardVisiteur");
            exit();
        }

        // Exécution de la mise à jour
        $result = $this->visiteurModel->modifierProfil($idVisiteur, $idUtilisateur, $nom, $email, $telephone, $age);

        if($result) {
            $_SESSION["nom"] = $nom; // Met à jour le nom en session pour l'affichage header
            $_SESSION["success"] = "Profil mis à jour avec succès.";
        } else {
            $_SESSION["error"] = "Une erreur est survenue lors de la mise à jour du profil.";
        }

        header("Location:index.php?action=dashboardVisiteur");
        exit();
    }
}
