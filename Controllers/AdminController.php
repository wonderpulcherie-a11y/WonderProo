<?php

require_once "./Models/EntrepriseModel.php";
require_once "./Models/SouscriptionModel.php";
require_once "./Models/PaiementModel.php";
require_once "./Models/DomaineModel.php";
require_once "./Models/ServiceModel.php";

class AdminController
{
    private $entrepriseModel;
    private $souscriptionModel;
    private $paiementModel;
    private $domaineModel;
    private $serviceModel;

    public function __construct()
    {
        $this->entrepriseModel = new Entreprise();
        $this->souscriptionModel = new Souscription();
        $this->paiementModel = new Paiement();
        $this->domaineModel = new Domaine();
        $this->serviceModel = new Service();
    }

    private function verifierAdmin()
    {
        if (!isset($_SESSION["id_utilisateur"]) || $_SESSION["type"] != "Admin") {
            header("Location: index.php?action=connexion");
            exit();
        }
    }

    public function dashboard()
    {
        $this->verifierAdmin();

        $entreprises = $this->entrepriseModel->getDemandesRecentes();
        $nbEntreprises = $this->entrepriseModel->compterEntreprises();
        $nbDemandes = $this->entrepriseModel->compterDemandes();
        $nbAbonnements = $this->souscriptionModel->compterAbonnementsActifs();
        $revenus = $this->paiementModel->getRevenusCumules();

        require_once "./Views/Admin/dashboard.php";
    }

    public function demandes()
    {
        $this->verifierAdmin();

        $demandes = $this->entrepriseModel->getDemandesEnAttente();

        require_once "./Views/Admin/demandes.php";
    }

    public function paiements()
    {
        $this->verifierAdmin();

        $paiements = $this->paiementModel->getAll();
        $revenus = $this->paiementModel->getRevenusCumules();

        require_once "./Views/Admin/paiements.php";
    }

    public function domaines()
    {
        $this->verifierAdmin();

        $domaines = $this->domaineModel->findAll();

        require_once "./Views/Admin/domaines.php";
    }

    public function services()
    {
        $this->verifierAdmin();

        $services = $this->serviceModel->getAll();

        require_once "./Views/Admin/services.php";
    }

    public function valider()
    {
        $this->verifierAdmin();

        $idEntreprise = $_GET["id"];
        $this->entrepriseModel->validerEntreprise($idEntreprise);
        $_SESSION["success"] = "Entreprise validée avec succès.";
        header("Location: index.php?action=dashboardAdmin");
        exit();
    }

    public function refuser()
    {
        $this->verifierAdmin();

        $idEntreprise = $_GET["id"];
        $this->entrepriseModel->refuserEntreprise($idEntreprise);
        $_SESSION["error"] = "Demande refusée.";
        header("Location: index.php?action=dashboardAdmin");
        exit();
    }

    public function toutesEntreprises()
    {
        $this->verifierAdmin();

        $entreprises = $this->entrepriseModel->getToutesEntreprises();

        require_once "./Views/Admin/toutes_entreprises.php";
    }
}
