<?php

require_once "Connexion.php";

class Entreprise
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
     * Ajouter une entreprise
     */
    public function ajouterEntreprise(
        $idEntreprise,
        $nomEntreprise,
        $quartier,
        $description,
        $rccm,
        $siteWeb,
        $logo,
        $idUtilisateur
    )
    {
        $sql = "
            INSERT INTO entreprise
            (
                id_entreprise,
                nom_entreprise,
                quartier,
                description,
                RCCM,
                site_web,
                logo,
                id_utilisateur
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            )
        ";

        return $this->db->request(
            $sql,
            [
                $idEntreprise,
                $nomEntreprise,
                $quartier,
                $description,
                $rccm,
                $siteWeb,
                $logo,
                $idUtilisateur
            ]
        );
    }
    
    public function trouverParUtilisateur($idUtilisateur)
    {
        $sql = "
            SELECT *
            FROM entreprise
            WHERE id_utilisateur = ?
        ";

        return $this->db->response(
            $sql,
            true,
            [$idUtilisateur]
        );
    }

    public function trouverParId($idEntreprise)
    {
        $sql = "
            SELECT
                e.*,
                u.nom,
                u.prenom,
                u.email,
                u.telephone
            FROM entreprise e
            INNER JOIN utilisateur u
                ON e.id_utilisateur = u.id_utilisateur
            WHERE e.id_entreprise = ?
        ";

        return $this->db->response(
            $sql,
            true,
            [$idEntreprise]
        );
    }

    public function findAll()
    {
        $sql = "
            SELECT *
            FROM entreprise
        ";

        return $this->db->response(
            $sql,
            false
        );
    }

    public function findLatest($limite = 3)
    {
        $sql = "
            SELECT *
            FROM entreprise
            WHERE statut = 'valide'
            ORDER BY id_entreprise DESC
            LIMIT ?
        ";

        $pdo = $this->db->connexion();

        $query = $pdo->prepare($sql);
        $query->bindValue(1, (int)$limite, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function autocompleteEntreprises($terme = '', $limite = 10)
    {
        $sql = "
            SELECT id_entreprise, nom_entreprise
            FROM entreprise
            WHERE statut = 'valide'
            AND nom_entreprise LIKE ?
            ORDER BY nom_entreprise ASC
            LIMIT ?
        ";

        $params = ["%$terme%", (int)$limite];
        return $this->db->response($sql, false, $params);
    }

    public function getDomaines($idEntreprise)
    {
        $sql = "
            SELECT d.nom_domaine
            FROM appartenance a
            INNER JOIN domaine_activite d
                ON a.id_domaine = d.id_domaine
            WHERE a.id_entreprise = ?
        ";

        return $this->db->response(
            $sql,
            false,
            [$idEntreprise]
        );
    }

    // public function getAnnonces($idEntreprise)
    // {
    //     $sql = "
    //         SELECT *
    //         FROM annonce
    //         WHERE id_entreprise = ?
    //         ORDER BY date_publication DESC
    //         LIMIT 5
    //     ";

    //     return $this->db->response(
    //         $sql,
    //         false,
    //         [$idEntreprise]
    //     );
    // }

    public function getServices($idEntreprise)
    {
        $sql = "
            SELECT s.libelle
            FROM proposition p
            INNER JOIN service s
                ON p.id_service = s.id_service
            WHERE p.id_entreprise = ?
        ";

        return $this->db->response(
            $sql,
            false,
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
            LIMIT 5
        ";

        return $this->db->response(
            $sql,
            false,
            [$idEntreprise]
        );
    }

    public function getDemandesEnAttente()
    {
        $sql = "
            SELECT *
            FROM entreprise
            WHERE statut = 'en attente'
            ORDER BY created_at DESC
        ";

        return $this->db->response(
            $sql,
            false
        );
    }

    public function validerEntreprise($idEntreprise)
    {
        $sql = "
            UPDATE entreprise
            SET statut='valide'
            WHERE id_entreprise=?
        ";

        return $this->db->request(
            $sql,
            [$idEntreprise]
        );
    }

    public function compterEntreprises()
    {
        $sql = "
            SELECT COUNT(*) total
            FROM entreprise
        ";

        return $this->db->response(
            $sql,
            true
        );
    }

    public function compterDemandes()
    {
        $sql = "
            SELECT COUNT(*) total
            FROM entreprise
            WHERE statut='en attente'
        ";

        return $this->db->response(
            $sql,
            true
        );
    }

    public function getDemandesRecentes()
    {
        $sql = "
            SELECT
                e.*,
                GROUP_CONCAT(
                    d.nom_domaine
                    SEPARATOR ', '
                ) AS domaines
            FROM entreprise e

            LEFT JOIN appartenance a
                ON e.id_entreprise = a.id_entreprise

            LEFT JOIN domaine_activite d
                ON a.id_domaine = d.id_domaine

            GROUP BY e.id_entreprise

            ORDER BY e.created_at DESC
        ";

        return $this->db->response(
            $sql,
            false
        );
    }

    public function refuserEntreprise($idEntreprise)
    {
        $sql = "
            UPDATE entreprise
            SET statut='rejete'
            WHERE id_entreprise=?
        ";

        return $this->db->request(
            $sql,
            [$idEntreprise]
        );
    }

    public function getToutesEntreprises()
    {
        $sql = "
            SELECT
                e.*,
                GROUP_CONCAT(
                    d.nom_domaine
                    SEPARATOR ', '
                ) AS domaines

            FROM entreprise e

            LEFT JOIN appartenance a
                ON e.id_entreprise = a.id_entreprise

            LEFT JOIN domaine_activite d
                ON a.id_domaine = d.id_domaine

            GROUP BY e.id_entreprise

            ORDER BY e.created_at DESC
        ";

        return $this->db->response(
            $sql,
            false
        );
    }

    /**
     * Modifie les informations de profil de l'entreprise et de son compte utilisateur associé.
     * Met à jour de façon synchrone les deux tables concernées.
     * 
     * @return bool Vrai en cas de succès global
     */
    public function modifierProfil($idEntreprise, $idUtilisateur, $nomEntreprise, $quartier, $description, $siteWeb, $logo, $nom, $prenom, $email, $telephone)
    {
        // Mise à jour de l'utilisateur lié (infos de contact)
        $sqlUser = "
            UPDATE utilisateur
            SET nom = ?, prenom = ?, email = ?, telephone = ?
            WHERE id_utilisateur = ?
        ";
        $resUser = $this->db->request($sqlUser, [$nom, $prenom, $email, $telephone, $idUtilisateur]);

        // Mise à jour de l'entreprise (infos professionnelles et logo)
        $sqlEnt = "
            UPDATE entreprise
            SET nom_entreprise = ?, quartier = ?, description = ?, site_web = ?, logo = ?
            WHERE id_entreprise = ?
        ";
        $resEnt = $this->db->request($sqlEnt, [$nomEntreprise, $quartier, $description, $siteWeb, $logo, $idEntreprise]);

        return $resUser && $resEnt;
    }

    /**
     * Recherche des entreprises validées selon plusieurs critères cumulatifs
     * (nom/description, quartier, domaine d'activité et service).
     * 
     * @param string $motcle Mot-clé ou nom d'entreprise
     * @param string $quartier Quartier de localisation
     * @param string $domaine Nom du domaine d'activité
     * @param string $service Libellé du service
     * @return array|false Liste des entreprises correspondantes
     */
    public function rechercherEntreprises($motcle = "", $quartier = "", $domaine = "", $service = "")
    {
        $sql = "
            SELECT DISTINCT e.*
            FROM entreprise e
            LEFT JOIN appartenance a ON e.id_entreprise = a.id_entreprise
            LEFT JOIN domaine_activite d ON a.id_domaine = d.id_domaine
            LEFT JOIN proposition p ON e.id_entreprise = p.id_entreprise
            LEFT JOIN service s ON p.id_service = s.id_service
            WHERE e.statut = 'valide'
        ";
        
        $params = [];

        // Filtre par mot-clé (nom ou description)
        if (!empty($motcle)) {
            $sql .= " AND (e.nom_entreprise LIKE ? OR e.description LIKE ?)";
            $params[] = "%$motcle%";
            $params[] = "%$motcle%";
        }

        // Filtre par quartier
        if (!empty($quartier)) {
            $sql .= " AND e.quartier = ?";
            $params[] = $quartier;
        }

        // Filtre par domaine d'activité
        if (!empty($domaine)) {
            $sql .= " AND d.nom_domaine = ?";
            $params[] = $domaine;
        }

        // Filtre par service proposé
        if (!empty($service)) {
            $sql .= " AND s.libelle = ?";
            $params[] = $service;
        }

        $sql .= " ORDER BY e.nom_entreprise ASC";

        return $this->db->response($sql, false, $params);
    }
}