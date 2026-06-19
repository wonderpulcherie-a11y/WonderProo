<?php
class Connexion {
    private $user;
    private $dsn;
    private $password;
    private $pdo = null;

    public function __construct() {
        $this->dsn = "mysql:host=localhost;dbname=wonderprotest;charset=utf8mb4"; 
        $this->user = "root";
        $this->password = "";
    } 

    public function connexion() {
    try {
        if ($this->pdo === null) {
            $this->pdo = new PDO($this->dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // LA LIGNE À AJOUTER : On force MySQL à parler en UTF-8 pour les accents
            $this->pdo->exec("SET NAMES utf8mb4");

            // Colonnes pour "Se souvenir de moi" et réinitialisation du mot de passe
            try {
                $cols = [
                    "remember_token" => "VARCHAR(64) NULL",
                    "reset_token" => "VARCHAR(64) NULL",
                    "reset_expires" => "DATETIME NULL"
                ];

                foreach ($cols as $col => $definition) {
                    $check = $this->pdo->query("SHOW COLUMNS FROM utilisateur LIKE '$col'")->fetch();
                    if (!$check) {
                        $this->pdo->exec("ALTER TABLE utilisateur ADD COLUMN $col $definition");
                    }
                }
            } catch (Exception $ex) {
                // Migration déjà appliquée ou table absente
            }

            // Migration des anciennes données service.id_entreprise vers proposition (n,n)
            try {
                $check = $this->pdo->query("SHOW COLUMNS FROM service LIKE 'id_entreprise'")->fetch();
                if ($check) {
                    $rows = $this->pdo->query("SELECT id_service, id_entreprise FROM service WHERE id_entreprise IS NOT NULL AND id_entreprise != ''")->fetchAll(PDO::FETCH_OBJ);
                    foreach ($rows as $row) {
                        $stmt = $this->pdo->prepare("INSERT IGNORE INTO proposition (id_entreprise, id_service) VALUES (?, ?)");
                        $stmt->execute([$row->id_entreprise, $row->id_service]);
                    }

                    // Supprimer la colonne et la contrainte legacy si elle existe
                    $fkName = null;
                    $stmtFk = $this->pdo->prepare(
                        "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE " .
                        "WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'service' AND COLUMN_NAME = 'id_entreprise' AND REFERENCED_TABLE_NAME = 'entreprise'"
                    );
                    $stmtFk->execute();
                    $fkName = $stmtFk->fetchColumn();

                    if ($fkName) {
                        $this->pdo->exec("ALTER TABLE service DROP FOREIGN KEY `$fkName`");
                    }

                    $this->pdo->exec("ALTER TABLE service DROP COLUMN IF EXISTS id_entreprise");
                }
            } catch (Exception $ex) {
                // Migration proposition déjà effectuée ou table legacy déjà corrigée
            }
        }
        return $this->pdo;
    } catch (Exception $e) {
        die("Erreur critique de connexion : " . $e->getMessage());
    }
}

    // Utilisé pour les INSERT, UPDATE, DELETE
    public function request($statement, $data = null) {
        $pdo = $this->connexion();
        $query = $pdo->prepare($statement);
        
        if ($data === null) {
            $result = $query->execute();
        } else {
            $result = $query->execute($data);
        }
        
        // On retourne simplement true ou false pour savoir si l'action a réussi
        return $result; 
    }

    // Utilisé pour les SELECT
    public function response($statement, $once = true, $data = null) {
        $pdo = $this->connexion();
        $query = $pdo->prepare($statement);
        
        if ($data === null) {
            $query->execute();
        } else {
            $query->execute($data);
        }
        
        $query->setFetchMode(PDO::FETCH_OBJ);
        
        if ($once == true) {
            return $query->fetch();
        } else {
            return $query->fetchAll();
        }
    }
}
?>