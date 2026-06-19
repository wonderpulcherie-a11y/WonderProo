
<?php

require_once "./Models/UtilisateurModel.php";
require_once "./Models/VisiteurModel.php";
require_once "./Models/EntrepriseModel.php";
require_once "./Models/DomaineModel.php";
require_once "./Models/AppartenanceModel.php";
require_once "./Models/SouscriptionModel.php";
require_once "./Models/AnnonceModel.php";
if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}

class UtilisateurController
{
    private $utilisateurModel;
    private $visiteurModel;
    private $entrepriseModel;
    private $domaineModel;
    private $appartenanceModel;
    private $souscriptionModel;
    private $annonceModel;

    public function __construct()
    {
        $this->utilisateurModel = new Utilisateur();
        $this->visiteurModel = new Visiteur();
        $this->entrepriseModel = new Entreprise();
        $this->domaineModel = new Domaine();
        $this->appartenanceModel = new Appartenance();
        $this->souscriptionModel = new Souscription();
        $this->annonceModel = new Annonce();
    }

    public function testDomaines()
    {
        $domaines = $this->domaineModel->findAll();

        echo "<pre>";
        print_r($domaines);
        echo "</pre>";
    }

    public function afficherInscription()
    {
        // récupérer tous les domaines

        $domaines = $this->domaineModel->findAll();

        // envoyer les données à la vue

        require_once "./Views/inscription.php";
    }

    public function enregistrer()
    {
        // Récupération des données du formulaire
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $telephone = $_POST["telephone"];
        $motDePasse = $_POST["mot_de_passe"];
        $type = $_POST["type_utilisateur"];
        $nomEntreprise = $_POST["nom_entreprise"] ?? "";
        $quartier = $_POST["quartier"] ?? "";
        $description = $_POST["description"] ?? "";
        $rccm = $_POST["rccm"] ?? "";
        $documentRccm = "";
        $siteWeb = $_POST["site_web"] ?? "";
        $domaines = $_POST["domaines"] ?? [];
        
        
        
        // Vérifier si l'email existe déjà

        $utilisateurExiste =
        $this->utilisateurModel->emailExiste($email);

        if($utilisateurExiste)
        {
            die("Cet email existe déjà.");
        }

        // Génération d'un identifiant unique
        $idUtilisateur = uniqid("USR-");

        // Cryptage du mot de passe
        $motDePasseCrypte = password_hash($motDePasse, PASSWORD_DEFAULT);
        // Enregistrement
        $documentRccm = null;

        if(
            isset($_FILES["document_rccm"])
            &&
            $_FILES["document_rccm"]["error"] == 0
        )
        {
            $nomFichier =
                time() . "_" .
                basename($_FILES["document_rccm"]["name"]);

            $dossier =
                "public/uploads/rccm/";

            if(!is_dir($dossier))
            {
                mkdir(
                    $dossier,
                    0777,
                    true
                );
            }

            move_uploaded_file(
                $_FILES["document_rccm"]["tmp_name"],
                $dossier . $nomFichier
            );

            $documentRccm =
                $dossier . $nomFichier;
        }

       $resultat =
        $this->utilisateurModel->ajouterUtilisateur(
            $idUtilisateur,
            $nom,
            $prenom,
            $email,
            $telephone,
            $motDePasseCrypte,
            $type
        );

    if($resultat && $type == "Entreprise")
        {
            $idEntreprise = uniqid("ENT-");
            $entrepriseAjoutee = $this->entrepriseModel->ajouterEntreprise(
                $idEntreprise,
                $nomEntreprise,
                $quartier,
                $description,
                $rccm,
                $siteWeb,
                "",
                $idUtilisateur
            );
            $_SESSION["id_entreprise"] = $idEntreprise;

            if($entrepriseAjoutee)
            {
                foreach($domaines as $idDomaine)
                {
                    $this->appartenanceModel->ajouterAppartenance($idEntreprise, $idDomaine);
                }
                $idSouscription = uniqid("SOU-");
                $dateExpiration =date("Y-m-d H:i:s", strtotime("+3 months"));
                $this->souscriptionModel->ajouterSouscription($idSouscription,$idEntreprise,"ABO-ESSAI",$dateExpiration);
            }
        }

        if($resultat)
        {
            $_SESSION["id_utilisateur"] = $idUtilisateur;
            $_SESSION["type"] = $type;


            // Si l'utilisateur est un visiteur
            if($type == "Visiteur")
            {
                $idVisiteur = uniqid("VIS-");

                $this->visiteurModel->ajouterVisiteur(
                    $idVisiteur,
                    $idUtilisateur
                );
                $_SESSION["id_visiteur"] = $idVisiteur;
            }
            $_SESSION["success"] ="Votre demande a été enregistrée avec succès.";
            
            if($type == "Entreprise")
            {
                header(
                    "Location:index.php?action=dashboardEntreprise"
                );
            }
            else
            {
                header(
                    "Location:index.php"
                );
            }

            exit();
        }
        else
        {
            echo "Erreur lors de l'enregistrement";
        }

        // if(isset($_FILES["document_rccm"])&& $_FILES["document_rccm"]["error"] == 0)
        // {
        //     $nomFichier =
        //         uniqid("RCCM_")
        //         . "_"
        //         . basename(
        //             $_FILES["document_rccm"]["name"]
        //         );

        //     $destination =
        //         "uploads/rccm/"
        //         . $nomFichier;

        //     move_uploaded_file(
        //         $_FILES["document_rccm"]["tmp_name"],
        //         $destination
        //     );

        //     $documentRccm = $destination;
        // }
    }
}