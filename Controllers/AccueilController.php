<?php

require_once "./Models/EntrepriseModel.php";
require_once "./Models/DomaineModel.php";
require_once "./Models/AnnonceModel.php";
require_once "./Models/CommentaireModel.php";
require_once "./Models/ServiceModel.php";

/**
 * Contrôleur gérant les pages publiques de l'annuaire (Accueil, Détails entreprise, Recherche multicritères)
 */
class AccueilController
{
    private $entrepriseModel;
    private $domaineModel;
    private $annonceModel;
    private $commentaireModel;
    private $serviceModel;

    /**
     * Constructeur - Initialisation de tous les modèles nécessaires
     */
    public function __construct()
    {
        $this->entrepriseModel = new Entreprise();
        $this->domaineModel = new Domaine();
        $this->annonceModel = new Annonce();
        $this->commentaireModel = new Commentaire();
        $this->serviceModel = new Service();
    }

    /**
     * Affiche la page d'accueil de l'annuaire avec les domaines, annonces et entreprises populaires
     */
    public function accueil()
    {
        // Récupérer les données pour l'accueil
        $entreprises = $this->entrepriseModel->findLatest(3);
        $domaines = $this->domaineModel->findAll();
        
        // Toutes les annonces actives (filtrage par date)
        $annonces = $this->annonceModel->getDernieresAnnonces(6);
        
        // Récupérer la liste des domaines pour le formulaire de recherche de l'accueil
        $tous_les_domaines_select = $this->domaineModel->findAll();
            
        require_once "./Views/accueil.php";
    }

    public function autocompleteEntreprises()
    {
        // Accept both 'term' (jquery-ui) and 'query' (custom frontend)
        $terme = trim($_GET["term"] ?? $_GET["query"] ?? "");
        $suggestions = $this->entrepriseModel->autocompleteEntreprises($terme);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($suggestions ?: []);
        exit();
    }

    /**
     * Affiche le profil public détaillé d'une entreprise avec ses avis
     */
    public function detailsEntreprise()
    {
        $idEntreprise = $_GET["id"];
        
        // Récupération des données d'entreprise et des avis
        $domaines = $this->entrepriseModel->getDomaines($idEntreprise);
        $entreprise = $this->entrepriseModel->trouverParId($idEntreprise);
        $commentaires = $this->commentaireModel->getCommentairesEntreprise($idEntreprise);
        $moyenne = $this->commentaireModel->getMoyenneNote($idEntreprise);
        $totalAvis = $this->commentaireModel->getNombreAvis($idEntreprise);
        
        // Récupérer uniquement les annonces actives de l'entreprise
        $annonces = $this->annonceModel->getAnnoncesActivesByEntreprise($idEntreprise);
        // Incrémente le compteur de vues pour chaque visite publique (sauf si c'est le propriétaire connecté)
        // $visiteurIdEntreprise = $_SESSION["id_entreprise"] ?? null;
        // if ($visiteurIdEntreprise !== $idEntreprise) {
        //     $this->entrepriseModel->incrementViews($idEntreprise);
        //     // Refresh enterprise data to show updated view count
        //     $entreprise = $this->entrepriseModel->trouverParId($idEntreprise);
        // }
        
        // Correction du chemin de la vue : elle se trouve dans le sous-dossier Entreprise
        require_once "./Views/Entreprise/details.php";
    }

    /**
     * Gère la recherche multicritères et affiche la page des résultats de recherche d'entreprises
     */
    public function entreprises()
    {
        // Récupération des critères de filtrage
        $motcle = trim($_GET["motcle"] ?? "");
        $quartier = trim($_GET["quartier"] ?? "");
        $domaine = trim($_GET["domaine"] ?? "");
        $service = trim($_GET["service"] ?? "");

        // Exécution de la recherche cumulée
        $entreprises = $this->entrepriseModel->rechercherEntreprises($motcle, $quartier, $domaine, $service);

        // Alimentation des listes déroulantes de filtre sur la page de résultats
        $domaines = $this->domaineModel->findAll();
        $services = $this->serviceModel->getDistinctServices();

        // Rendu de la vue de recherche
        require_once "./Views/entreprises.php";
    }
}