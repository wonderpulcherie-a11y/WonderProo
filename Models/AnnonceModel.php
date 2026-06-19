<?php

require_once "Connexion.php";

class Annonce
{
    private $db;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->db = new Connexion();
    }

    /**
     * Ajouter une annonce
     */
   public function ajouterAnnonce(
    $idAnnonce,
    $titre,
    $contenu,
    $image,
    $dateDebut,
    $dateFin,
    $idEntreprise
    )
    {
        $sql = "
            INSERT INTO annonce
            (
                id_annonce,
                titre,
                contenu,
                image,
                date_debut,
                date_fin,
                id_entreprise
            )
            VALUES
            (
                ?, ?, ?, ?, ?, ?, ?
            )
        ";

        return $this->db->request(
            $sql,
            [
                $idAnnonce,
                $titre,
                $contenu,
                $image,
                $dateDebut,
                $dateFin,
                $idEntreprise
            ]
        );
    }

    /**
     * Compter le nombre d'annonces
     * publiées par une entreprise
     */
    public function compterAnnoncesEntreprise($idEntreprise)
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM annonce
            WHERE id_entreprise = ?
        ";

        return $this->db->response(
            $sql,
            true,
            [$idEntreprise]
        );
    }
    public function getByEntreprise($idEntreprise)
    {
        $sql = "
            SELECT *
            FROM annonce
            WHERE id_entreprise = ?
            ORDER BY date_publication DESC
        ";

        return $this->db->response(
            $sql,
            false,
            [$idEntreprise]
        );
    }
    /**
     * Récupère uniquement les annonces encore actives (la date du jour est entre date_debut et date_fin)
     * pour une entreprise donnée. Utile sur la page publique de l'entreprise.
     * 
     * @param string $idEntreprise
     * @return array|false
     */
    public function getAnnoncesActivesByEntreprise($idEntreprise)
    {
        $sql = "
            SELECT *
            FROM annonce
            WHERE id_entreprise = ?
            AND CURDATE() BETWEEN date_debut AND date_fin
            ORDER BY date_publication DESC
        ";
        return $this->db->response($sql, false, [$idEntreprise]);
    }
    public function supprimerAnnonce($idAnnonce)
    {
        $sql = "
            DELETE FROM annonce
            WHERE id_annonce = ?
        ";

        return $this->db->request(
            $sql,
            [$idAnnonce]
        );
    }

    public function getById($idAnnonce)
    {
        $sql = "
            SELECT *
            FROM annonce
            WHERE id_annonce = ?
        ";

        return $this->db->response(
            $sql,
            true,
            [$idAnnonce]
        );
    }

    public function modifierAnnonce(
    $idAnnonce,
    $titre,
    $contenu,
    $image,
    $date_debut,
    $date_fin 
    )
    {
        $sql = "
            UPDATE annonce
            SET
                titre = ?,
                contenu = ?,
                image = ?,
                date_debut = ?,
                date_fin = ?
            WHERE id_annonce = ?
        ";

        return $this->db->request(
            $sql,
            [
                $titre,
                $contenu,
                $image,
                $date_debut,
                $date_fin, 
                $idAnnonce
            ]
        );
    }

    public function getDernieresAnnonces($limite = 6)
    {
        $sql = "
            SELECT
                a.*,
                e.nom_entreprise,
                e.logo,
                ab.type_abonnement

            FROM annonce a

            INNER JOIN entreprise e
                ON e.id_entreprise = a.id_entreprise

            INNER JOIN souscription s
                ON s.id_entreprise = e.id_entreprise

            INNER JOIN abonnement ab
                ON ab.id_abonnement = s.id_abonnement

            WHERE s.statut = 'actif'
            AND ab.type_abonnement = '1_an'
            AND CURDATE() BETWEEN a.date_debut
            AND a.date_fin

            ORDER BY a.date_publication DESC

            LIMIT $limite
        ";

        return $this->db->response(
            $sql,
            false
        );
    }
}