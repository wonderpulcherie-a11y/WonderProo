<?php

require_once "Connexion.php";

class Utilisateur
{
    private $db;

    /**
     * Constructeur
     * Création de la connexion
     */
    public function __construct()
    {
        $connexion = new Connexion();

        $this->db = $connexion;
    }

    /**
     * Vérifier si un email existe déjà
     */
    public function emailExiste($email)
    {
        $sql = "
            SELECT *
            FROM utilisateur
            WHERE email = ?
        ";

        return $this->db->response(
            $sql,
            true,
            [$email]
        );
    }
    /**
 * Ajouter un utilisateur
 */
    public function ajouterUtilisateur(
        $id,
        $nom,
        $prenom,
        $email,
        $telephone,
        $motDePasse,
        $type
    )
    {
        $sql = "
            INSERT INTO utilisateur
            (
                id_utilisateur,
                nom,
                prenom,
                email,
                telephone,
                mot_de_passe,
                type_utilisateur
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            )
        ";

//         var_dump([
//     $id,
//     $nom,
//     $prenom,
//     $email,
//     $telephone,
//     $motDePasse,
//     $type
// ]);
        return $this->db->request(
            $sql,
            [
                $id,
                $nom,
                $prenom,
                $email,
                $telephone,
                $motDePasse,
                $type
            ]
        );
    }

        /**
     * Rechercher un utilisateur par email
     */
    public function trouverParEmail($email)
    {
        $sql = "
            SELECT *
            FROM utilisateur
            WHERE email = ?
        ";

        return $this->db->response(
            $sql,
            true,
            [$email]
        );
    }

    /**
     * Recherche un utilisateur par son token "Se souvenir de moi"
     */
    public function trouverParRememberToken($token)
    {
        $sql = "
            SELECT *
            FROM utilisateur
            WHERE remember_token = ?
        ";

        return $this->db->response($sql, true, [$token]);
    }

    /**
     * Enregistre le token de connexion persistante
     */
    public function updateRememberToken($idUtilisateur, $token)
    {
        $sql = "
            UPDATE utilisateur
            SET remember_token = ?
            WHERE id_utilisateur = ?
        ";

        return $this->db->request($sql, [$token, $idUtilisateur]);
    }

    /**
     * Supprime le token de connexion persistante
     */
    public function clearRememberToken($idUtilisateur)
    {
        $sql = "
            UPDATE utilisateur
            SET remember_token = NULL
            WHERE id_utilisateur = ?
        ";

        return $this->db->request($sql, [$idUtilisateur]);
    }

    /**
     * Génère un token de réinitialisation de mot de passe
     */
    public function definirResetToken($idUtilisateur, $token, $expires)
    {
        $sql = "
            UPDATE utilisateur
            SET reset_token = ?, reset_expires = ?
            WHERE id_utilisateur = ?
        ";

        return $this->db->request($sql, [$token, $expires, $idUtilisateur]);
    }

    /**
     * Recherche un utilisateur par token de réinitialisation valide
     */
    public function trouverParResetToken($token)
    {
        $sql = "
            SELECT *
            FROM utilisateur
            WHERE reset_token = ?
        ";

        $utilisateur = $this->db->response($sql, true, [$token]);

        if (!$utilisateur || empty($utilisateur->reset_expires)) {
            return false;
        }

        $expires = strtotime($utilisateur->reset_expires);
        if ($expires === false || $expires <= time()) {
            return false;
        }

        return $utilisateur;
    }

    /**
     * Met à jour le mot de passe et efface les tokens
     */
    public function reinitialiserMotDePasse($idUtilisateur, $motDePasseHash)
    {
        $sql = "
            UPDATE utilisateur
            SET mot_de_passe = ?,
                reset_token = NULL,
                reset_expires = NULL
            WHERE id_utilisateur = ?
        ";

        return $this->db->request($sql, [$motDePasseHash, $idUtilisateur]);
    }
}