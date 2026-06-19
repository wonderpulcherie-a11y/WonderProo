<?php

require_once "./Models/CommentaireModel.php";

class CommentaireController
{
    private $commentaireModel;

    public function __construct()
    {
        $this->commentaireModel =
        new Commentaire();
    }

    public function publierCommentaire()
    {
    
        if(!isset($_SESSION["id_visiteur"]))
        {
            $_SESSION["error"] =
            "Vous devez vous connecter pour commenter.";

            header(
                "Location:index.php?action=connexion"
            );
            exit();
        }

        $idCommentaire =
        uniqid("COM-");

        $description =
        trim($_POST["description"]);

        $note =
        (int) $_POST["note"];

        $idEntreprise =
        $_POST["id_entreprise"];

        $idVisiteur =
        $_SESSION["id_visiteur"];

        $avisExistant =
        $this->commentaireModel
            ->avisExiste(
                $idVisiteur,
                $idEntreprise
            );

        if($avisExistant)
        {
            $_SESSION["error"] =
            "Vous avez déjà laissé un avis pour cette entreprise.";

            header(
                "Location:index.php?action=detailsEntreprise&id="
                . $idEntreprise
            );

            exit();
        }
        $resultat =
        $this->commentaireModel
            ->ajouterCommentaire(
                $idCommentaire,
                $description,
                $note,
                $idVisiteur,
                $idEntreprise
            );

       if($resultat)
        {
            $_SESSION["success"] =
            "Votre avis a été publié avec succès.";

            header(
                "Location:index.php?action=detailsEntreprise&id="
                . $idEntreprise
            );

            exit();
        }

        echo "Erreur lors du commentaire";
    }
    public function supprimerCommentaire()
    {
        $idCommentaire =
        $_GET["id"];

        $commentaire =
        $this->commentaireModel
            ->getById($idCommentaire);

        $this->commentaireModel
            ->supprimerCommentaire(
                $idCommentaire
            );

        $_SESSION["success"] =
        "Avis supprimé avec succès.";

        // Redirection conditionnelle selon la provenance (dashboard ou détails)
        $source = $_GET["source"] ?? "details";
        if ($source == "dashboard") {
            header("Location:index.php?action=dashboardVisiteur");
        } else {
            header(
                "Location:index.php?action=detailsEntreprise&id="
                . $commentaire->id_entreprise
            );
        }

        exit();
    }
    public function modifierCommentaire()
    {
        $idCommentaire =
        $_POST["id_commentaire"];

        $description =
        trim($_POST["description"]);

        $note =
        (int) $_POST["note"];

        $commentaire =
        $this->commentaireModel
            ->getById($idCommentaire);

        $this->commentaireModel
            ->modifierCommentaire(
                $idCommentaire,
                $description,
                $note
            );

        $_SESSION["success"] =
        "Avis modifié avec succès.";

        // Redirection conditionnelle selon la provenance (dashboard ou détails)
        $source = $_POST["source"] ?? "details";
        if ($source == "dashboard") {
            header("Location:index.php?action=dashboardVisiteur");
        } else {
            header(
                "Location:index.php?action=detailsEntreprise&id="
                . $commentaire->id_entreprise
            );
        }

        exit();
    }

    public function repondreCommentaire()
    {
        if (!isset($_SESSION["id_entreprise"])) {
            header("Location:index.php?action=connexion");
            exit();
        }

        $idCommentaire = $_POST["id_commentaire"] ?? "";
        $reponse = trim($_POST["reponse"] ?? "");

        if (empty($idCommentaire) || $reponse === "") {
            $_SESSION["error"] = "La réponse ne peut pas être vide.";
            header("Location:index.php?action=commentairesEntreprise");
            exit();
        }

        $commentaire = $this->commentaireModel->getById($idCommentaire);
        if (!$commentaire || $commentaire->id_entreprise !== $_SESSION["id_entreprise"]) {
            $_SESSION["error"] = "Commentaire introuvable ou accès non autorisé.";
            header("Location:index.php?action=commentairesEntreprise");
            exit();
        }

        $this->commentaireModel->repondreCommentaire($idCommentaire, $reponse);
        $_SESSION["success"] = "Réponse enregistrée avec succès.";
        header("Location:index.php?action=commentairesEntreprise");
        exit();
    }

    public function afficherModification()
    {
        $idCommentaire = $_GET["id"];

        $commentaire =
        $this->commentaireModel
            ->getById($idCommentaire);

        require_once
        "./Views/Commentaire/modifier_commentaire.php";
    }

    /**
     * Affiche tous les avis d'une entreprise
     */
    public function tousCommentaires()
    {
        $idEntreprise = $_GET["id"] ?? "";

        if (empty($idEntreprise)) {
            header("Location: index.php?action=accueil");
            exit();
        }

        require_once "./Models/EntrepriseModel.php";
        $entrepriseModel = new Entreprise();
        $entreprise = $entrepriseModel->trouverParId($idEntreprise);

        if (!$entreprise) {
            $_SESSION["error"] = "Entreprise introuvable.";
            header("Location: index.php?action=accueil");
            exit();
        }

        $commentaires = $this->commentaireModel->getTousCommentairesEntreprise($idEntreprise);
        $moyenneObj = $this->commentaireModel->getMoyenneNote($idEntreprise);
        $moyenne = $moyenneObj->moyenne ?? 0;
        $totalAvisObj = $this->commentaireModel->getNombreAvis($idEntreprise);
        $totalAvis = $totalAvisObj->total ?? 0;

        require_once "./Views/Commentaire/tous_commentaires.php";
    }
}
