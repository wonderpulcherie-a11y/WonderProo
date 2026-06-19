<?php

require_once "./Models/AnnonceModel.php";
require_once "./Models/SouscriptionModel.php";


class AnnonceController
{
    private $annonceModel;
    private $souscriptionModel;
    

    public function __construct()
    {
        $this->annonceModel = new Annonce();
        $this->souscriptionModel = new Souscription();
       
    }

    public function publier()
    {
        $idEntreprise = $_SESSION["id_entreprise"];
        $titre = trim($_POST["titre"]);
        $contenu = trim($_POST["contenu"]);
        $image = null;
        $dateDebut = $_POST["date_debut"];
        $dateFin   = $_POST["date_fin"];
       

        $souscription =$this->souscriptionModel->getSouscriptionActive($idEntreprise);
        if(!$souscription)
        {
            die(
                "Aucune souscription active."
            );
        }

        $total = $this->annonceModel->compterAnnoncesEntreprise($idEntreprise);
        // $nbAnnonces =
        // $this->annonceModel
        //     ->compterAnnonces(
        //         $idEntreprise
        //     );
      if(
        $souscription->limite_annonces != NULL
        &&
        $total->total >= $souscription->limite_annonces
        )
        {
            $_SESSION["error"] =
            "Vous avez atteint la limite de votre offre d'essai.";

            header(
            "Location:index.php?action=abonnements"
            );

            exit();
        }
        if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0)
        {
            $extension =
            pathinfo(
                $_FILES["image"]["name"],
                PATHINFO_EXTENSION
            );

            $nomImage =
            uniqid("annonce_")
            . "."
            . $extension;

            $destination =
            "src/uploads/annonces/"
            . $nomImage;

            move_uploaded_file(
                $_FILES["image"]["tmp_name"],
                $destination
            );

            $image = $destination;
        }
       $idAnnonce = uniqid("ANN-");
        $resultat = $this->annonceModel->ajouterAnnonce(
                $idAnnonce,
                $titre,
                $contenu,
                $image,
                $dateDebut,
                $dateFin,
                $idEntreprise
            );

        if($resultat)
        {
            $_SESSION["success"] = "Annonce publiée avec succès.";
            header("Location:index.php?action=mesAnnonces");
            exit();
        }

        $_SESSION["error"] = "Erreur lors de la publication.";
        header("Location:index.php?action=formAnnonce");
        exit();
    }

    public function voir()
    {
        $idAnnonce = $_GET["id"];
        $annonce = $this->annonceModel->getById($idAnnonce);
        require_once "./Views/Entreprise/voir_annonce.php";
    }
    

    public function voirParVisiteur()
    {
        $idAnnonce = $_GET["id"];

        $annonce =
        $this->annonceModel
            ->getById($idAnnonce);

        require_once
        "./Views/Entreprise/voir_annonce_par_visiteur.php";
    }

    public function modifier()
    {
        $idAnnonce = $_GET["id"];

        $annonce =
        $this->annonceModel
            ->getById($idAnnonce);

        require_once
        "./Views/Entreprise/modifier_annonce.php";
    }
    
    public function supprimer()
    {
        $idAnnonce = $_GET["id"] ?? null;

        if(!$idAnnonce)
        {
            die("Annonce introuvable");
        }

        $this->annonceModel
            ->supprimerAnnonce($idAnnonce);

        $_SESSION["success"] = "Annonce supprimée.";
        header("Location:index.php?action=mesAnnonces");
        exit();
    }

    public function updateAnnonce()
    {
        
        $idAnnonce = $_POST["id_annonce"];
        $titre = $_POST["titre"];
        $contenu = $_POST["contenu"];
        $dateDebut = $_POST["date_debut"];
        $dateFin = $_POST["date_fin"];
        $image = null;

        if(
            isset($_FILES["image"])
            &&
            $_FILES["image"]["error"] == 0
        )
        {
            $extension =
            pathinfo(
                $_FILES["image"]["name"],
                PATHINFO_EXTENSION
            );

            $nomImage =
            uniqid("annonce_")
            . "."
            . $extension;

            $destination =
            "src/uploads/annonces/"
            . $nomImage;

            move_uploaded_file(
                $_FILES["image"]["tmp_name"],
                $destination
            );

            $image = $destination;
        }
        $resultat =
        $this->annonceModel
            ->modifierAnnonce(
                $idAnnonce,
                $titre,
                $contenu,
                $image,
                $dateDebut,
                $dateFin 
            );

        if($resultat)
        {
            $_SESSION["success"] = "Annonce modifiée avec succès.";
            header("Location:index.php?action=mesAnnonces");
            exit();
        }

        $_SESSION["error"] = "Erreur lors de la modification.";
        header("Location:index.php?action=mesAnnonces");
        exit();
    }
}