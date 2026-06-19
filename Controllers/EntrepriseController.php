<?php

require_once "./Models/EntrepriseModel.php";
require_once "./Models/SouscriptionModel.php";
require_once "./Models/AnnonceModel.php";
require_once "./Models/CommentaireModel.php";
require_once "./Models/ServiceModel.php";

/**
 * Contrôleur gérant les actions de l'entreprise (profil, annonces, services, abonnements)
 */
class EntrepriseController
{
    private $entrepriseModel;
    private $souscriptionModel;
    private $annonceModel;
    private $commentaireModel;
    private $serviceModel;

    /**
     * Constructeur - Initialisation des modèles
     */
    public function __construct()
    {
        $this->entrepriseModel = new Entreprise();
        $this->souscriptionModel = new Souscription();
        $this->annonceModel = new Annonce();
        $this->commentaireModel = new Commentaire();
        $this->serviceModel = new Service();
    }

    public function dashboard()
    {
        $idEntreprise = $_SESSION["id_entreprise"];
        $entreprise = $this->entrepriseModel->trouverParId($idEntreprise);
        $annonces = $this->annonceModel->getByEntreprise($idEntreprise);
        $souscription = $this->souscriptionModel->getSouscriptionActive($idEntreprise);
        $joursRestants = 0;
        $commentaires = $this->commentaireModel->getCommentairesEntreprise($idEntreprise, 3);
        $totalAvisObj = $this->commentaireModel->getNombreAvis($idEntreprise);
        $totalAvis = $totalAvisObj->total ?? 0;

        if ($entreprise->statut == "en attente")
        {
            require_once "./Views/Entreprise/en_attente.php";
            return;
        }

        if ($entreprise->statut == "rejete")
        {
            require_once "./Views/Entreprise/rejete.php";
            return;
        }

        if ($souscription)
        {
            $aujourdhui = new DateTime();
            $expiration = new DateTime($souscription->date_expiration);
            $joursRestants = $aujourdhui->diff($expiration)->days;
        }

        $page = "./Views/Entreprise/dashboard_content.php";
        require_once "./Views/Entreprise/layout.php";
    }
    public function details()
    {
        $idEntreprise = $_GET["id"];
        $domaines = $this->entrepriseModel->getDomaines($idEntreprise);
        $entreprise = $this->entrepriseModel->trouverParId($idEntreprise);
        $commentaires = $this->commentaireModel->getCommentairesEntreprise($idEntreprise);
        $moyenne =$this->commentaireModel->getMoyenneNote($idEntreprise);
        $totalAvis = $this->commentaireModel->getNombreAvis($idEntreprise);
        $annonces = $this->annonceModel->getByEntreprise($idEntreprise);
        require_once "./Views/Entreprise/details.php";
    }
    public function formulaireAnnonce()
    {
        require_once
        "./Views/Entreprise/ajouter_annonce.php";
    }
    public function enregistrerAnnonce()
    {
        $idAnnonce = uniqid("ANN-");
        $titre = trim($_POST["titre"] ?? "");
        $contenu = trim($_POST["contenu"] ?? "");
        $image = "";
        $dateDebut = $_POST["date_debut"] ?? date('Y-m-d');
        $dateFin = $_POST["date_fin"] ?? date('Y-m-d', strtotime('+30 days'));
        $idEntreprise = $_SESSION["id_entreprise"];

        $this->annonceModel->ajouterAnnonce(
            $idAnnonce,
            $titre,
            $contenu,
            $image,
            $dateDebut,
            $dateFin,
            $idEntreprise
        );

        header("Location:index.php?action=mesAnnonces");
    }
    public function mesAnnonces()
    {
        if (!isset($_SESSION["id_entreprise"])) {
            header("Location: index.php?action=connexion");
            exit();
        }

        $idEntreprise = $_SESSION["id_entreprise"];
        $entreprise = $this->entrepriseModel->trouverParId($idEntreprise);
        $souscription = $this->souscriptionModel->getSouscriptionActive($idEntreprise);
        $annonces = $this->annonceModel->getByEntreprise($idEntreprise);

        $page = "./Views/Entreprise/mes_annonces_content.php";
        require_once "./Views/Entreprise/layout.php";
    }

    /**
     * Affiche les notifications de l'entreprise connectée
     */
    public function notifications()
    {
        if (!isset($_SESSION["id_entreprise"])) {
            header("Location: index.php?action=connexion");
            exit();
        }

        $idEntreprise = $_SESSION["id_entreprise"];
        $entreprise = $this->entrepriseModel->trouverParId($idEntreprise);
        $souscription = $this->souscriptionModel->getSouscriptionActive($idEntreprise);

        $notifications = [];

        if ($entreprise->statut == "en attente") {
            $notifications[] = [
                "type" => "warning",
                "titre" => "Compte en attente de validation",
                "message" => "Votre demande d'inscription est en cours d'examen par l'administrateur."
            ];
        }

        if ($entreprise->statut == "valide") {
            $notifications[] = [
                "type" => "success",
                "titre" => "Compte validé",
                "message" => "Votre entreprise est visible dans l'annuaire WonderPro."
            ];
        }

        if ($souscription) {
            $expiration = new DateTime($souscription->date_expiration);
            $aujourdhui = new DateTime();
            $joursRestants = $aujourdhui->diff($expiration)->days;

            $notifications[] = [
                "type" => $joursRestants <= 7 ? "danger" : "info",
                "titre" => "Abonnement " . $souscription->id_abonnement,
                "message" => "Votre abonnement expire le " . $expiration->format("d/m/Y") . " ($joursRestants jour(s) restant(s))."
            ];
        } else {
            $notifications[] = [
                "type" => "danger",
                "titre" => "Aucun abonnement actif",
                "message" => "Souscrivez à un abonnement pour publier des annonces."
            ];
        }

        $nbServices = count($this->serviceModel->getByEntreprise($idEntreprise) ?: []);
        if ($nbServices == 0) {
            $notifications[] = [
                "type" => "info",
                "titre" => "Ajoutez vos services",
                "message" => "Complétez votre profil en ajoutant les services que vous proposez."
            ];
        }

        $page = "./Views/Entreprise/notifications_content.php";
        require_once "./Views/Entreprise/layout.php";
    }

    /**
     * Affiche l'interface de gestion des services de l'entreprise connectée
     */
    public function servicesEntreprise()
    {
        // Vérification de connexion
        if(!isset($_SESSION["id_entreprise"])) {
            header("Location:index.php?action=connexion");
            exit();
        }

        $idEntreprise = $_SESSION["id_entreprise"];
        $entreprise = $this->entrepriseModel->trouverParId($idEntreprise);
        $souscription = $this->souscriptionModel->getSouscriptionActive($idEntreprise);
        $services = $this->serviceModel->getByEntreprise($idEntreprise);

        // Chargement de la vue des services dans le layout de l'entreprise
        $page = "./Views/Entreprise/services_content.php";
        require_once "./Views/Entreprise/layout.php";
    }

    public function commentairesEntreprise()
    {
        if(!isset($_SESSION["id_entreprise"])) {
            header("Location:index.php?action=connexion");
            exit();
        }

        $idEntreprise = $_SESSION["id_entreprise"];
        $entreprise = $this->entrepriseModel->trouverParId($idEntreprise);
        $souscription = $this->souscriptionModel->getSouscriptionActive($idEntreprise);
        $commentaires = $this->commentaireModel->getTousCommentairesEntreprise($idEntreprise);
        $moyenneObj = $this->commentaireModel->getMoyenneNote($idEntreprise);
        $moyenne = $moyenneObj->moyenne ?? 0;
        $totalAvisObj = $this->commentaireModel->getNombreAvis($idEntreprise);
        $totalAvis = $totalAvisObj->total ?? 0;

        $page = "./Views/Entreprise/commentaires_content.php";
        require_once "./Views/Entreprise/layout.php";
    }

    /**
     * Traite l'ajout d'un nouveau service par l'entreprise connectée
     */
    public function ajouterService()
    {
        if(!isset($_SESSION["id_entreprise"])) {
            header("Location:index.php?action=connexion");
            exit();
        }

        $idEntreprise = $_SESSION["id_entreprise"];
        $libelle = trim($_POST["libelle"] ?? "");
        $description = trim($_POST["description"] ?? "");

        if(empty($libelle)) {
            $_SESSION["error"] = "Le libellé du service est obligatoire.";
            header("Location:index.php?action=servicesEntreprise");
            exit();
        }

        $idService = uniqid("SRV-");
        $result = $this->serviceModel->ajouterService($idService, $libelle, $description, $idEntreprise);

        if($result) {
            $_SESSION["success"] = "Service ajouté avec succès.";
        } else {
            $_SESSION["error"] = "Erreur lors de la création du service.";
        }

        header("Location:index.php?action=servicesEntreprise");
        exit();
    }

    /**
     * Traite la suppression d'un service par l'entreprise connectée
     */
    public function supprimerService()
    {
        if(!isset($_SESSION["id_entreprise"])) {
            header("Location:index.php?action=connexion");
            exit();
        }

        $idEntreprise = $_SESSION["id_entreprise"];
        $idService = $_GET["id"] ?? "";

        if(empty($idService)) {
            $_SESSION["error"] = "Service introuvable.";
            header("Location:index.php?action=servicesEntreprise");
            exit();
        }

        $result = $this->serviceModel->supprimerService($idService, $idEntreprise);

        if($result) {
            $_SESSION["success"] = "Service supprimé avec succès.";
        } else {
            $_SESSION["error"] = "Erreur lors de la suppression du service.";
        }

        header("Location:index.php?action=servicesEntreprise");
        exit();
    }

    /**
     * Affiche la page du profil de l'entreprise connectée
     */
    public function profilEntreprise()
    {
        // Vérification de connexion
        if(!isset($_SESSION["id_entreprise"])) {
            header("Location:index.php?action=connexion");
            exit();
        }

        $idEntreprise = $_SESSION["id_entreprise"];
        $entreprise = $this->entrepriseModel->trouverParId($idEntreprise);
        $souscription = $this->souscriptionModel->getSouscriptionActive($idEntreprise);

        // Chargement du profil dans le layout de l'entreprise
        $page = "./Views/Entreprise/profil_content.php";
        require_once "./Views/Entreprise/layout.php";
    }

    /**
     * Traite la mise à jour des informations de profil de l'entreprise connectée (incluant logo)
     */
    public function updateProfil()
    {
        // Vérification de connexion
        if(!isset($_SESSION["id_entreprise"])) {
            header("Location:index.php?action=connexion");
            exit();
        }

        $idEntreprise = $_SESSION["id_entreprise"];
        $entreprise = $this->entrepriseModel->trouverParId($idEntreprise);
        $idUtilisateur = $entreprise->id_utilisateur;

        // Récupération des données du formulaire
        $nomEntreprise = trim($_POST["nom_entreprise"]);
        $quartier = trim($_POST["quartier"]);
        $description = trim($_POST["description"]);
        $siteWeb = trim($_POST["site_web"]);
        $nom = trim($_POST["nom"]);
        $prenom = trim($_POST["prenom"]);
        $email = trim($_POST["email"]);
        $telephone = trim($_POST["telephone"]);

        // Gestion du logo (conserve l'actuel par défaut)
        $logo = $entreprise->logo;

        // Cas de suppression du logo demandé par l'utilisateur
        if(isset($_POST["supprimer_logo"]) && $_POST["supprimer_logo"] == "1") {
            if(!empty($logo) && file_exists($logo)) {
                @unlink($logo);
            }
            $logo = null;
        }

        // Cas d'upload d'un nouveau logo
        if(isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $filename = $_FILES["logo"]["name"];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if(in_array($ext, $allowed)) {
                $dir = "public/uploads/logos/";
                if(!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }

                // Supprimer l'ancien fichier s'il existe
                if(!empty($logo) && file_exists($logo)) {
                    @unlink($logo);
                }

                // Génération d'un nom unique pour éviter les collisions de cache navigateur
                $newName = "logo_" . uniqid() . "." . $ext;
                $destination = $dir . $newName;

                if(move_uploaded_file($_FILES["logo"]["tmp_name"], $destination)) {
                    $logo = $destination;
                }
            } else {
                $_SESSION["error"] = "Format d'image non valide (formats acceptés : JPG, PNG, GIF, WEBP).";
                header("Location:index.php?action=profilEntreprise");
                exit();
            }
        }

        // Enregistrement des modifications en base de données
        $result = $this->entrepriseModel->modifierProfil(
            $idEntreprise,
            $idUtilisateur,
            $nomEntreprise,
            $quartier,
            $description,
            $siteWeb,
            $logo,
            $nom,
            $prenom,
            $email,
            $telephone
        );

        if($result) {
            $_SESSION["success"] = "Profil mis à jour avec succès.";
        } else {
            $_SESSION["error"] = "Erreur lors de la mise à jour du profil.";
        }

        header("Location:index.php?action=profilEntreprise");
        exit();
    }
}