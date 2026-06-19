<?php
// =========================================================================
// WONDERPRO - ROUTEUR AVEC GESTION DES ACCÈS (SESSIONS)
// =========================================================================

// On démarre la session PHP au tout début. 
session_start();

// Inclusion de la connexion à la base de données
require_once 'Models/Connexion.php';

// Récupération de la page demandée dans l'URL (accueil par défaut)
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

// L'AIGUILLAGE
switch ($page) {

    case 'accueil':
        // Tout le monde (connecté ou non) peut voir l'accueil, les domaines et chercher
        require_once './Views/accueil.php';
        break;

    // =========================================================================
    // AJOUT DE L'OPTION B : PAGE TOUTES LES ENTREPRISES
    // =========================================================================
    case 'entreprises':
        // Cette page est publique, on inclut directement sa vue
        require_once './Views/entreprises.php';
        break;

    case 'connexion':
        require_once './Views/connexion_entreprise.php';
        break;

    case 'details':
        // =================================================================
        // ZONE SÉCURISÉE : Vérification de la connexion
        // =================================================================
        if (!isset($_SESSION['utilisateur'])) {
            
            // Le visiteur n'est pas connecté -> On le redirige vers la page de connexion
            header('Location: index.php?page=connexion&message=connexion_requise');
            exit(); 
            
        } else {
            
            // L'utilisateur est connecté ! On récupère l'ID de l'entreprise demandée
            $id_entreprise = isset($_GET['id']) ? $_GET['id'] : null;
            
            // On charge la vue des détails
            require_once 'Views/details_entreprise.php';
        }
        break;

    default:
        echo "<h1 style='text-align:center; margin-top:50px;'>Erreur 404 : Page introuvable</h1>";
        break;
}




require_once "Controllers/Inscription.php";

if(isset($_GET["action"]))
{
    if($_GET["action"] == "test")
    {
        $controleur = new InscriptionController();

        $controleur->enregistrer();
    }
}
?>