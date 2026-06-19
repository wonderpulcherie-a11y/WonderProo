<?php

require_once "./Models/SouscriptionModel.php";
require_once "./Models/PaiementModel.php";
require_once "./Models/EntrepriseModel.php";

/**
 * Contrôleur gérant les souscriptions d'entreprises et la simulation de paiement
 */
class SouscriptionController
{
    private $souscriptionModel;
    private $paiementModel;
    private $entrepriseModel;

    /**
     * Constructeur - Initialisation des modèles requis
     */
    public function __construct()
    {
        $this->souscriptionModel = new Souscription();
        $this->paiementModel = new Paiement();
        $this->entrepriseModel = new Entreprise();
    }

    /**
     * Initialise la demande de souscription en affichant l'interface de paiement
     */
    public function souscrire()
    {
        // Vérification de connexion
        if(!isset($_SESSION["id_entreprise"])) {
            header("Location:index.php?action=connexion");
            exit();
        }

        $idAbonnement = $_GET["id"] ?? "";
        $abonnement = $this->souscriptionModel->getAbonnement($idAbonnement);

        if(!$abonnement) {
            $_SESSION["error"] = "Formule d'abonnement introuvable.";
            header("Location:index.php?action=abonnements");
            exit();
        }

        $idEntreprise = $_SESSION["id_entreprise"];
        $entreprise = $this->entrepriseModel->trouverParId($idEntreprise);

        // Affichage de la page de simulation de paiement
        require_once "./Views/Entreprise/choix_paiement.php";
    }

    /**
     * Traite la validation du paiement simulé et crée la souscription correspondante
     */
    public function validerPaiement()
    {
        // Vérification de connexion
        if(!isset($_SESSION["id_entreprise"])) {
            header("Location:index.php?action=connexion");
            exit();
        }

        $idEntreprise = $_SESSION["id_entreprise"];
        $idAbonnement = $_POST["id_abonnement"] ?? "";
        $modePaiement = $_POST["mode_paiement"] ?? "";
        $montant = $_POST["montant"] ?? 0;
        $reference = trim($_POST["reference"] ?? "");
        
        $abonnement = $this->souscriptionModel->getAbonnement($idAbonnement);
        if(!$abonnement) {
            $_SESSION["error"] = "Formule d'abonnement invalide.";
            header("Location:index.php?action=abonnements");
            exit();
        }

        if(empty($reference)) {
            $_SESSION["error"] = "Veuillez saisir la référence unique de votre transaction.";
            header("Location:index.php?action=souscrire&id=" . urlencode($idAbonnement));
            exit();
        }

        // Calcul de la date d'expiration en fonction de la durée de l'abonnement
        $dateExpiration = date("Y-m-d H:i:s", strtotime("+" . $abonnement->duree_jours . " days"));

        // 1. Création de l'enregistrement de paiement (en attente d'association)
        $idPaiement = uniqid("PAY-");
        $paiementEnregistre = $this->paiementModel->enregistrerPaiement(
            $idPaiement,
            $montant,
            $modePaiement,
            'effectue', // Simulation réussie
            $reference,
            null
        );

        if($paiementEnregistre) {
            // 2. Archiver l'ancienne souscription de l'entreprise (passe de 'actif' à 'expire')
            // Nous exécutons une requête de désactivation des anciennes souscriptions
            try {
                $dbConn = new Connexion();
                $pdo = $dbConn->connexion();
                $sqlArchive = "UPDATE souscription SET statut = 'expire' WHERE id_entreprise = ? AND statut = 'actif'";
                $stmt = $pdo->prepare($sqlArchive);
                $stmt->execute([$idEntreprise]);
            } catch (Exception $ex) {
                // Erreur d'archivage ignorée
            }

            // 3. Création de la nouvelle souscription active
            $idSouscription = uniqid("SOU-");
            
            // Insertion manuelle ou via le modèle
            $souscriptionEnregistree = $this->souscriptionModel->ajouterSouscription(
                $idSouscription,
                $idEntreprise,
                $idAbonnement,
                $dateExpiration
            );

            if($souscriptionEnregistree) {
                // Associer le paiement à la souscription et vice versa
                // Mettre à jour la souscription avec id_paiement
                try {
                    $pdo = (new Connexion())->connexion();
                    $sqlUpdateSub = "UPDATE souscription SET id_paiement = ? WHERE id_souscription = ?";
                    $stmtUpdateSub = $pdo->prepare($sqlUpdateSub);
                    $stmtUpdateSub->execute([$idPaiement, $idSouscription]);
                } catch(Exception $ex) {}

                // Associer la souscription au paiement
                $this->paiementModel->associerSouscription($idPaiement, $idSouscription);

                $_SESSION["success"] = "Félicitations ! Votre abonnement " . htmlspecialchars($idAbonnement) . " a été activé avec succès. Référence : " . $reference;
            } else {
                $_SESSION["error"] = "Erreur lors de la création de la souscription.";
            }
        } else {
            $_SESSION["error"] = "Erreur lors de l'enregistrement du paiement.";
        }

        header("Location:index.php?action=dashboardEntreprise");
        exit();
    }

    /**
     * Redirige l'entreprise vers le renouvellement de son abonnement actif
     */
    public function renouvelerAbonnement()
    {
        if(!isset($_SESSION["id_entreprise"])) {
            header("Location:index.php?action=connexion");
            exit();
        }

        $idEntreprise = $_SESSION["id_entreprise"];
        $souscription = $this->souscriptionModel->getSouscriptionActive($idEntreprise);

        if(!$souscription) {
            $_SESSION["error"] = "Aucun abonnement actif à renouveler. Choisissez une formule.";
            header("Location:index.php?action=abonnements");
            exit();
        }

        header("Location:index.php?action=souscrire&id=" . urlencode($souscription->id_abonnement));
        exit();
    }
}