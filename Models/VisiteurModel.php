<?php

require_once "Connexion.php";

class Visiteur
{
    private $db;

    public function __construct()
    {
        $this->db = new Connexion();
    }

    /**
     * Ajouter un visiteur
     */
    public function ajouterVisiteur(
        $idVisiteur,
        $idUtilisateur
    )
    {
        $sql = "
            INSERT INTO visiteur
            (
                id_visiteur,
                id_utilisateur
            )
            VALUES
            (
                ?,
                ?
            )
        ";

        return $this->db->request(
            $sql,
            [
                $idVisiteur,
                $idUtilisateur
            ]
        );
    }
    public function trouverParUtilisateur(
    $idUtilisateur
    )
    {
        $sql = "
            SELECT *
            FROM visiteur
            WHERE id_utilisateur = ?
        ";

        return $this->db->response(
            $sql,
            true,
            [$idUtilisateur]
        );
    }

    /**
     * Récupère un visiteur et ses informations de compte utilisateur par son identifiant de visiteur
     * 
     * @param string $idVisiteur Identifiant du visiteur
     * @return object|false
     */
    public function trouverParId($idVisiteur)
    {
        $sql = "
            SELECT v.*, u.nom, u.prenom, u.email, u.telephone
            FROM visiteur v
            INNER JOIN utilisateur u ON v.id_utilisateur = u.id_utilisateur
            WHERE v.id_visiteur = ?
        ";

        return $this->db->response(
            $sql,
            true,
            [$idVisiteur]
        );
    }

    /**
     * Modifie les informations de profil du visiteur et de son utilisateur associé
     * 
     * @return bool Vrai en cas de succès
     */
    public function modifierProfil($idVisiteur, $idUtilisateur, $nom, $email, $telephone, $age)
    {
        // 1. Mise à jour des coordonnées globales de l'utilisateur
        $sqlUser = "
            UPDATE utilisateur
            SET nom = ?, email = ?, telephone = ?
            WHERE id_utilisateur = ?
        ";
        $resUser = $this->db->request($sqlUser, [$nom, $email, $telephone, $idUtilisateur]);

        // 2. Mise à jour des infos spécifiques au visiteur
        $sqlVis = "
            UPDATE visiteur
            SET age = ?
            WHERE id_visiteur = ?
        ";
        $resVis = $this->db->request($sqlVis, [$age, $idVisiteur]);

        return $resUser && $resVis;
    }
}