<?php

require_once "./Models/UtilisateurModel.php";

class InscriptionController
{
    public function enregistrer()
    {
        $utilisateur = new Utilisateur();

        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $telephone = $_POST["telephone"];

        $mot_de_passe = password_hash(
            $_POST["mot_de_passe"],
            PASSWORD_DEFAULT
        );

        $type = $_POST["type_utilisateur"];

        $id = uniqid();

        $utilisateur->ajouter(
            $id,
            $nom,
            $prenom,
            $email,
            $telephone,
            $mot_de_passe,
            $type
        );

        echo "Utilisateur enregistré";
    }
}