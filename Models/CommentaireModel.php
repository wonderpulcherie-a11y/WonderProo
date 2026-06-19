<?php

require_once "Connexion.php";

class Commentaire
{
    private $db;

    public function __construct()
    {
        $this->db = new Connexion();
    }
    public function ajouterCommentaire(
        $idCommentaire,
        $description,
        $note,
        $idVisiteur,
        $idEntreprise
    )
    {
        $sql = "
            INSERT INTO commentaire
            (
                id_commentaire,
                description,
                note,
                id_visiteur,
                id_entreprise
            )
            VALUES
            (
                ?, ?, ?, ?, ?
            )
        ";

        return $this->db->request(
            $sql,
            [
                $idCommentaire,
                $description,
                $note,
                $idVisiteur,
                $idEntreprise
            ]
        );
    }

    public function getCommentairesEntreprise(
    $idEntreprise,
    $limite = 3
    )
    {
        $sql = "
            SELECT c.*, u.nom, u.prenom
            FROM commentaire c
            INNER JOIN visiteur v ON c.id_visiteur = v.id_visiteur
            INNER JOIN utilisateur u ON v.id_utilisateur = u.id_utilisateur
            WHERE c.id_entreprise = ?
            ORDER BY c.date_commentaire DESC
            LIMIT $limite
        ";

        return $this->db->response(
            $sql,
            false,
            [$idEntreprise]
        );
    }

    /**
     * Récupère tous les avis d'une entreprise avec les infos du visiteur
     */
    public function getTousCommentairesEntreprise($idEntreprise)
    {
        $sql = "
            SELECT c.*, u.nom, u.prenom
            FROM commentaire c
            INNER JOIN visiteur v ON c.id_visiteur = v.id_visiteur
            INNER JOIN utilisateur u ON v.id_utilisateur = u.id_utilisateur
            WHERE c.id_entreprise = ?
            ORDER BY c.date_commentaire DESC
        ";

        return $this->db->response($sql, false, [$idEntreprise]);
    }

    public function getMoyenneNote(
        $idEntreprise
    )
    {
        $sql = "
            SELECT
                AVG(note) AS moyenne
            FROM commentaire
            WHERE id_entreprise = ?
        ";

        return $this->db->response(
            $sql,
            true,
            [$idEntreprise]
        );
    }

    public function getNombreAvis(
        $idEntreprise
    )
    {
        $sql = "
            SELECT
                COUNT(*) AS total
            FROM commentaire
            WHERE id_entreprise = ?
        ";

        return $this->db->response(
            $sql,
            true,
            [$idEntreprise]
        );
    }
 
    public function avisExiste(
        $idVisiteur,
        $idEntreprise
    )
    {
        $sql = "
            SELECT *
            FROM commentaire
            WHERE
                id_visiteur = ?
                AND id_entreprise = ?
        ";

        return $this->db->response(
            $sql,
            true,
            [
                $idVisiteur,
                $idEntreprise
            ]
        );
    }
    public function modifierCommentaire(
    $idCommentaire,
    $description,
    $note
    )
    {
        $sql = "
            UPDATE commentaire
            SET
                description = ?,
                note = ?
            WHERE id_commentaire = ?
        ";

        return $this->db->request(
            $sql,
            [
                $description,
                $note,
                $idCommentaire
            ]
        );
    }
    public function supprimerCommentaire(
    $idCommentaire
    )
    {
        $sql = "
            DELETE FROM commentaire
            WHERE id_commentaire = ?
        ";

        return $this->db->request(
            $sql,
            [$idCommentaire]
        );
    }
    public function getById(
    $idCommentaire
    )
    {
        $sql = "
            SELECT *
            FROM commentaire
            WHERE id_commentaire = ?
        ";

        return $this->db->response(
            $sql,
            true,
            [$idCommentaire]
        );
    }

    public function repondreCommentaire(
        $idCommentaire,
        $reponse
    )
    {
        $sql = "
            UPDATE commentaire
            SET
                reponse = ?,
                reponse_date = NOW()
            WHERE id_commentaire = ?
        ";

        return $this->db->request(
            $sql,
            [
                $reponse,
                $idCommentaire
            ]
        );
    }

    public function updateCommentaire(
        $idCommentaire,
        $description,
        $note
    )
    {
        $sql = "
            UPDATE commentaire
            SET
                description = ?,
                note = ?
            WHERE id_commentaire = ?
        ";

        return $this->db->request(
            $sql,
            [
                $description,
                $note,
                $idCommentaire
            ]
        );
    }

    /**
     * Récupère tous les avis et notes laissés par un visiteur donné, avec le nom de l'entreprise associée.
     * 
     * @param string $idVisiteur Identifiant du visiteur
     * @return array|false
     */
    public function getCommentairesVisiteur($idVisiteur)
    {
        $sql = "
            SELECT c.*, e.nom_entreprise, e.logo
            FROM commentaire c
            INNER JOIN entreprise e ON c.id_entreprise = e.id_entreprise
            WHERE c.id_visiteur = ?
            ORDER BY c.date_commentaire DESC
        ";

        return $this->db->response(
            $sql,
            false,
            [$idVisiteur]
        );
    }
}
?>