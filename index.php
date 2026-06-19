<?php
session_start();

require_once "Controllers/UtilisateurController.php";
require_once "Controllers/ConnexionController.php";
require_once "Controllers/AccueilController.php";
require_once "Controllers/AnnonceController.php";

// Reconnexion automatique via cookie "Se souvenir de moi"
ConnexionController::tenterAutoConnexion();

// Mise à jour automatique des souscriptions expirées
require_once "Models/SouscriptionModel.php";
$souscriptionModel = new Souscription();
$souscriptionModel->mettreAJourSouscriptionsExpirees();

$action = $_GET["action"] ?? "accueil";

switch ($action) {
    case "accueil":
        $controller = new AccueilController();
        $controller->accueil();
        break;

    case "entreprises":
        $controller = new AccueilController();
        $controller->entreprises();
        break;

    case "autocompleteEntreprises":
        $controller = new AccueilController();
        $controller->autocompleteEntreprises();
        break;

    case "inscription":
        $controller = new UtilisateurController();
        $controller->afficherInscription();
        break;

    case "enregistrer":
        $controller = new UtilisateurController();
        $controller->enregistrer();
        break;

    case "connexion":
        require_once "./Views/connexion.php";
        break;

    case "connecter":
        $controller = new ConnexionController();
        $controller->connecter();
        break;

    case "motDePasseOublie":
        $controller = new ConnexionController();
        $controller->afficherMotDePasseOublie();
        break;

    case "traiterMotDePasseOublie":
        $controller = new ConnexionController();
        $controller->traiterMotDePasseOublie();
        break;

    case "reinitialiserMotDePasse":
        $controller = new ConnexionController();
        $controller->afficherReinitialisation();
        break;

    case "traiterReinitialisation":
        $controller = new ConnexionController();
        $controller->traiterReinitialisation();
        break;

    case "logout":
        $controller = new ConnexionController();
        $controller->deconnexion();
        break;

    case "mentionsLegales":
        require_once "./Views/mentions_legales.php";
        break;

    case "confidentialite":
        require_once "./Views/confidentialite.php";
        break;

    case "dashboardEntreprise":
        require_once "Controllers/EntrepriseController.php";
        $controller = new EntrepriseController();
        $controller->dashboard();
        break;

    case "servicesEntreprise":
        require_once "Controllers/EntrepriseController.php";
        $controller = new EntrepriseController();
        $controller->servicesEntreprise();
        break;

    case "ajouterService":
        require_once "Controllers/EntrepriseController.php";
        $controller = new EntrepriseController();
        $controller->ajouterService();
        break;

    case "supprimerService":
        require_once "Controllers/EntrepriseController.php";
        $controller = new EntrepriseController();
        $controller->supprimerService();
        break;

    case "profilEntreprise":
        require_once "Controllers/EntrepriseController.php";
        $controller = new EntrepriseController();
        $controller->profilEntreprise();
        break;

    case "updateProfil":
        require_once "Controllers/EntrepriseController.php";
        $controller = new EntrepriseController();
        $controller->updateProfil();
        break;

    case "commentairesEntreprise":
        require_once "Controllers/EntrepriseController.php";
        $controller = new EntrepriseController();
        $controller->commentairesEntreprise();
        break;

    case "repondreCommentaire":
        require_once "Controllers/CommentaireController.php";
        $controller = new CommentaireController();
        $controller->repondreCommentaire();
        break;

    case "mesAnnonces":
        require_once "Controllers/EntrepriseController.php";
        $controller = new EntrepriseController();
        $controller->mesAnnonces();
        break;

    case "notifications":
        require_once "Controllers/EntrepriseController.php";
        $controller = new EntrepriseController();
        $controller->notifications();
        break;

    case "dashboardAdmin":
        require_once "Controllers/AdminController.php";
        $controller = new AdminController();
        $controller->dashboard();
        break;

    case "demandesAdmin":
        require_once "Controllers/AdminController.php";
        $controller = new AdminController();
        $controller->demandes();
        break;

    case "paiementsAdmin":
        require_once "Controllers/AdminController.php";
        $controller = new AdminController();
        $controller->paiements();
        break;

    case "domainesAdmin":
        require_once "Controllers/AdminController.php";
        $controller = new AdminController();
        $controller->domaines();
        break;

    case "servicesAdmin":
        require_once "Controllers/AdminController.php";
        $controller = new AdminController();
        $controller->services();
        break;

    case "dashboardVisiteur":
        require_once "Controllers/VisiteurController.php";
        $controller = new VisiteurController();
        $controller->dashboardVisiteur();
        break;

    case "updateProfilVisiteur":
        require_once "Controllers/VisiteurController.php";
        $controller = new VisiteurController();
        $controller->updateProfilVisiteur();
        break;

    case "testDomaines":
        $controller = new UtilisateurController();
        $controller->testDomaines();
        break;

    case "detailsEntreprise":
        require_once "Controllers/EntrepriseController.php";
        $controller = new EntrepriseController();
        $controller->details();
        break;

    case "formAnnonce":
        require_once "./Views/Entreprise/publierAnnonce.php";
        break;

    case "publierAnnonce":
        $controller = new AnnonceController();
        $controller->publier();
        break;

    case "voirAnnonce":
        $controller = new AnnonceController();
        $controller->voir();
        break;

    case "modifierAnnonce":
        $controller = new AnnonceController();
        $controller->modifier();
        break;

    case "updateAnnonce":
        $controller = new AnnonceController();
        $controller->updateAnnonce();
        break;

    case "supprimerAnnonce":
        $controller = new AnnonceController();
        $controller->supprimer();
        break;

    case "validerEntreprise":
        require_once "Controllers/AdminController.php";
        $controller = new AdminController();
        $controller->valider();
        break;

    case "refuserEntreprise":
        require_once "Controllers/AdminController.php";
        $controller = new AdminController();
        $controller->refuser();
        break;

    case "abonnements":
        require_once "./Views/Entreprise/abonnements.php";
        break;

    case "souscrire":
        require_once "Controllers/SouscriptionController.php";
        $controller = new SouscriptionController();
        $controller->souscrire();
        break;

    case "validerPaiement":
        require_once "Controllers/SouscriptionController.php";
        $controller = new SouscriptionController();
        $controller->validerPaiement();
        break;

    case "renouvelerAbonnement":
        require_once "Controllers/SouscriptionController.php";
        $controller = new SouscriptionController();
        $controller->renouvelerAbonnement();
        break;

    case "toutesEntreprises":
        require_once "Controllers/AdminController.php";
        $controller = new AdminController();
        $controller->toutesEntreprises();
        break;

    case "publierCommentaire":
        require_once "Controllers/CommentaireController.php";
        $controller = new CommentaireController();
        $controller->publierCommentaire();
        break;

    case "tousCommentaires":
        require_once "Controllers/CommentaireController.php";
        $controller = new CommentaireController();
        $controller->tousCommentaires();
        break;

    case "supprimerCommentaire":
        require_once "Controllers/CommentaireController.php";
        $controller = new CommentaireController();
        $controller->supprimerCommentaire();
        break;

    case "modifierCommentaire":
        require_once "Controllers/CommentaireController.php";
        $controller = new CommentaireController();
        $controller->afficherModification();
        break;

    case "updateCommentaire":
        require_once "Controllers/CommentaireController.php";
        $controller = new CommentaireController();
        $controller->modifierCommentaire();
        break;

    default:
        echo "Page introuvable.";
        break;
}
