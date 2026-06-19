<?php

require_once "Connexion.php";

/**
 * Modèle de gestion des transactions de paiement dans le système
 */
class Paiement
{
    private $db;

    /**
     * Constructeur - Initialisation de la connexion à la base de données
     */
    public function __construct()
    {
        $this->db = new Connexion();
    }

    /**
     * Enregistre un nouveau paiement en base de données
     * 
     * @param string $idPaiement Identifiant unique du paiement
     * @param float $montant Montant du paiement en FCFA
     * @param string $modePaiement Mode choisi ('Orange Money', 'MTN Mobile Money', 'Carte Bancaire')
     * @param string $statutPaiement Statut ('en_attente', 'effectue', 'echoue')
     * @param string $reference Transaction reference (OM-xxx, MTN-xxx, CB-xxx)
     * @param string|null $idSouscription Identifiant optionnel de la souscription liée
     * @return bool Vrai si l'insertion réussit
     */
    public function enregistrerPaiement($idPaiement, $montant, $modePaiement, $statutPaiement, $reference, $idSouscription = null)
    {
        $sql = "
            INSERT INTO paiement (id_paiement, montant, mode_paiement, statut_paiement, reference_transaction, id_souscription)
            VALUES (?, ?, ?, ?, ?, ?)
        ";

        return $this->db->request(
            $sql,
            [$idPaiement, $montant, $modePaiement, $statutPaiement, $reference, $idSouscription]
        );
    }

    /**
     * Assigne l'identifiant de la souscription créée à un paiement après sa génération
     * 
     * @param string $idPaiement Identifiant du paiement
     * @param string $idSouscription Identifiant de la souscription
     * @return bool Vrai en cas de succès
     */
    public function associerSouscription($idPaiement, $idSouscription)
    {
        $sql = "
            UPDATE paiement
            SET id_souscription = ?
            WHERE id_paiement = ?
        ";

        return $this->db->request($sql, [$idSouscription, $idPaiement]);
    }

    /**
     * Calcule le total des paiements effectués
     */
    public function getRevenusCumules()
    {
        $sql = "
            SELECT COALESCE(SUM(montant), 0) AS total
            FROM paiement
            WHERE statut_paiement = 'effectue'
        ";

        return $this->db->response($sql, true);
    }

    /**
     * Liste tous les paiements pour l'administration
     */
    public function getAll()
    {
        $sql = "
            SELECT p.*, s.id_entreprise, e.nom_entreprise
            FROM paiement p
            LEFT JOIN souscription s ON p.id_souscription = s.id_souscription
            LEFT JOIN entreprise e ON s.id_entreprise = e.id_entreprise
            ORDER BY p.date_paiement DESC
        ";

        return $this->db->response($sql, false);
    }
}
