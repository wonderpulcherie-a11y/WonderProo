-- ======================================
-- FIXES DATABASE - WonderPro
-- ======================================

-- 1. Supprimer la contrainte FK cassée sur service (si elle existe)
-- Vérifier et supprimer les colonnes id_entreprise dans service si elles existent
ALTER TABLE service DROP FOREIGN KEY IF EXISTS fk_service_entreprise;
ALTER TABLE service DROP COLUMN IF EXISTS id_entreprise;

-- 2. S'assurer que la table service n'a que les colonnes nécessaires
-- (id_service, libelle, description)
-- Les autres colonnes sont gérées via la table proposition

-- 3. Vérifier que la table proposition lie correctement service et entreprise
-- (elle l'est déjà dans le schema original)

-- ======================================
-- FIN DES FIXES
-- ======================================
