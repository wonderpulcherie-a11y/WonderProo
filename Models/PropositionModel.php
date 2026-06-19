<?php

require_once "Connexion.php";

/**
 * Modèle de la classe associative Proposition (relation n,n Entreprise <-> Service)
 */
class Proposition
{
    private $db;

    public function __construct()
    {
        $this->db = new Connexion();
    }

    /**
     * Lie une entreprise à un service via la table proposition
     */
    public function ajouterProposition($idEntreprise, $idService)
    {
        if ($this->propositionExiste($idEntreprise, $idService)) {
            return true;
        }

        $sql = "
            INSERT INTO proposition (id_entreprise, id_service)
            VALUES (?, ?)
        ";

        return $this->db->request($sql, [$idEntreprise, $idService]);
    }

    /**
     * Supprime le lien entre une entreprise et un service
     */
    public function supprimerProposition($idEntreprise, $idService)
    {
        $sql = "
            DELETE FROM proposition
            WHERE id_entreprise = ?
            AND id_service = ?
        ";

        return $this->db->request($sql, [$idEntreprise, $idService]);
    }

    /**
     * Vérifie si une proposition existe déjà
     */
    public function propositionExiste($idEntreprise, $idService)
    {
        $sql = "
            SELECT id_entreprise
            FROM proposition
            WHERE id_entreprise = ?
            AND id_service = ?
        ";

        return (bool) $this->db->response($sql, true, [$idEntreprise, $idService]);
    }

    /**
     * Compte le nombre de services proposés par une entreprise
     */
    public function compterParEntreprise($idEntreprise)
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM proposition
            WHERE id_entreprise = ?
        ";

        return $this->db->response($sql, true, [$idEntreprise]);
    }
}
