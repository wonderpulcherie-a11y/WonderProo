<?php

require_once "Connexion.php";

class Souscription
{
    private $db;

    public function __construct()
    {
        $this->db = new Connexion();
    }

    /**
     * Ajouter une souscription
     */
    public function ajouterSouscription(
        $idSouscription,
        $idEntreprise,
        $idAbonnement,
        $dateExpiration
    )
    {
        $sql = "
            INSERT INTO souscription
            (
                id_souscription,
                id_entreprise,
                id_abonnement,
                date_expiration
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?
            )
        ";

        return $this->db->request(
            $sql,
            [
                $idSouscription,
                $idEntreprise,
                $idAbonnement,
                $dateExpiration
            ]
        );
    }

    public function modifierSouscription(
    $idEntreprise,
    $idAbonnement,
    $dateExpiration
    )
    {
        $sql = "
            UPDATE souscription
            SET
                id_abonnement = ?,
                date_expiration = ?,
                statut = 'actif'
            WHERE id_entreprise = ?
        ";

        return $this->db->request(
            $sql,
            [
                $idAbonnement,
                $dateExpiration,
                $idEntreprise
            ]
        );
    }

    /**
 * Récupérer la souscription active
 */
    public function getSouscriptionActive(
        $idEntreprise
    )
    {
        $sql = "
            SELECT
                s.*,
                a.type_abonnement,
                a.limite_annonces
            FROM souscription s
            INNER JOIN abonnement a
            ON s.id_abonnement = a.id_abonnement
            WHERE s.id_entreprise = ?
            AND s.statut = 'actif'
        ";

        return $this->db->response(
            $sql,
            true,
            [$idEntreprise]
        );
    }

    /**
     * Récupère les détails d'un abonnement par son identifiant unique.
     * 
     * @param string $idAbonnement Identifiant de l'abonnement
     * @return object|false
     */
    public function getAbonnement($idAbonnement)
    {
        $sql = "
            SELECT *
            FROM abonnement
            WHERE id_abonnement = ?
        ";

        return $this->db->response(
            $sql,
            true,
            [$idAbonnement]
        );
    }

    /**
     * Met à jour automatiquement les souscriptions qui ont dépassé leur date d'expiration.
     * Change le statut de 'actif' à 'expire' en base de données.
     * 
     * @return bool
     */
    public function mettreAJourSouscriptionsExpirees()
    {
        $sql = "
            UPDATE souscription
            SET statut = 'expire'
            WHERE date_expiration < NOW()
            AND statut = 'actif'
        ";

        return $this->db->request($sql);
    }

    /**
     * Compte les abonnements actuellement actifs
     */
    public function compterAbonnementsActifs()
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM souscription
            WHERE statut = 'actif'
        ";

        return $this->db->response($sql, true);
    }
}