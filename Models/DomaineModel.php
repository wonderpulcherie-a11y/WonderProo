<?php

require_once "Connexion.php";

class Domaine
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
     * Récupérer tous les domaines
     */
    public function findAll()
    {
        $sql = "
            SELECT *
            FROM domaine_activite
            ORDER BY nom_domaine
        ";

        return $this->db->response(
            $sql,
            false
        );
    }
}