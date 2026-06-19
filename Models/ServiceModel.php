<?php

require_once "Connexion.php";
require_once "PropositionModel.php";

/**
 * Modèle de gestion du catalogue global des services.
 * La relation n,n avec les entreprises passe par la table proposition.
 */
class Service
{
    private $db;
    private $propositionModel;

    public function __construct()
    {
        $this->db = new Connexion();
        $this->propositionModel = new Proposition();
    }

    /**
     * Récupère les services proposés par une entreprise (via proposition)
     */
    public function getByEntreprise($idEntreprise)
    {
        $sql = "
            SELECT s.*
            FROM proposition p
            INNER JOIN service s ON p.id_service = s.id_service
            WHERE p.id_entreprise = ?
            ORDER BY s.libelle ASC
        ";

        return $this->db->response($sql, false, [$idEntreprise]);
    }

    /**
     * Ajoute un service au catalogue et le lie à l'entreprise via proposition.
     * Si le libellé existe déjà, seul le lien proposition est créé.
     */
    public function ajouterService($idService, $libelle, $description, $idEntreprise)
    {
        $existant = $this->trouverParLibelle($libelle);

        if ($existant) {
            return $this->propositionModel->ajouterProposition($idEntreprise, $existant->id_service);
        }

        $sql = "
            INSERT INTO service (id_service, libelle, description)
            VALUES (?, ?, ?)
        ";

        $inserted = $this->db->request($sql, [$idService, $libelle, $description]);

        if (!$inserted) {
            return false;
        }

        return $this->propositionModel->ajouterProposition($idEntreprise, $idService);
    }

    /**
     * Retire un service de l'offre de l'entreprise (suppression dans proposition uniquement)
     */
    public function supprimerService($idService, $idEntreprise)
    {
        return $this->propositionModel->supprimerProposition($idEntreprise, $idService);
    }

    /**
     * Récupère un service par son identifiant
     */
    public function getById($idService)
    {
        $sql = "
            SELECT *
            FROM service
            WHERE id_service = ?
        ";

        return $this->db->response($sql, true, [$idService]);
    }

    /**
     * Recherche un service par son libellé exact
     */
    public function trouverParLibelle($libelle)
    {
        $sql = "
            SELECT *
            FROM service
            WHERE libelle = ?
        ";

        return $this->db->response($sql, true, [$libelle]);
    }

    /**
     * Liste tous les libellés de services distincts (pour les filtres de recherche)
     */
    public function getDistinctServices()
    {
        $sql = "
            SELECT DISTINCT libelle
            FROM service
            ORDER BY libelle ASC
        ";

        return $this->db->response($sql, false);
    }

    /**
     * Liste l'ensemble du catalogue de services (administration)
     */
    public function getAll()
    {
        $sql = "
            SELECT s.*, COUNT(p.id_entreprise) AS nb_entreprises
            FROM service s
            LEFT JOIN proposition p ON s.id_service = p.id_service
            GROUP BY s.id_service
            ORDER BY s.libelle ASC
        ";

        return $this->db->response($sql, false);
    }
}
