$motDePasseCrypte =
password_hash(
    $_POST["mot_de_passe"],
    PASSWORD_DEFAULT
);



Élevage de poissons
Forage d'eau
Menuiserie aluminium
Énergie solaire
Impression numérique
Décoration événementielle
Transport interurbain


connexion  → afficher le formulaire
connecter  → traiter le formulaire

 SELECT e.nom_entreprise, a.id_domaine, d.nom_domaine FROM entreprise e LEFT JOIN appartenance a ON e.id_entreprise = a.id_entreprise LEFT JOIN domaine_activite d ON a.id_domaine = d.id_domaine;

 Les limites de publication sont entièrement pilotées par la base de données. Le contrôleur ne connaît pas les offres STANDARD, VIP ou VVIP. Il lit simplement la valeur limite_annonces associée à l'abonnement actif. Cela permet de modifier les offres commerciales sans modifier le code PHP.