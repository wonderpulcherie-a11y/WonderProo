<?php

require_once "Connexion.php";

class Appartenance
{
    private $db;

    public function __construct()
    {
        $this->db = new Connexion();
    }

    /**
     * Associer une entreprise à un domaine
     */
    public function ajouterAppartenance(
        $idEntreprise,
        $idDomaine
    )
    {
        $sql = "
            INSERT INTO appartenance
            (
                id_entreprise,
                id_domaine
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
                $idEntreprise,
                $idDomaine
            ]
        );
    }
}