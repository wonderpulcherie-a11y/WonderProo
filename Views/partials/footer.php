<footer class="custom-footer mt-5 pt-5 pb-4">
    <div class="container">
        <div class="row g-4 text-start">
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand mb-3">
                    <a href="index.php?action=accueil" class="text-decoration-none d-flex align-items-center gap-2">
                        <img src="src/images/logo_simple_wonderpro.png" alt="" style="height: 100px;">
                    </a>
                </div>
                <p class="footer-description small mb-3">
                    L'annuaire professionnel de référence à Bafoussam. Connectez les entreprises locales
                    aux visiteurs en quête de services de qualité.
                </p>
                <div class="d-flex gap-2">
                    <a href="https://facebook.com" target="_blank" rel="noopener" class="social-box" title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener" class="social-box" title="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="https://wa.me/237692112388" target="_blank" rel="noopener" class="social-box" title="WhatsApp">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="footer-heading text-uppercase mb-3">Navigation</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="index.php?action=accueil" class="f-link">Accueil</a>
                    <a href="index.php?action=entreprises" class="f-link">Entreprises</a>
                    <a href="index.php?action=connexion" class="f-link">Connexion</a>
                    <a href="index.php?action=inscription" class="f-link">Inscription</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading text-uppercase mb-3">Pour les professionnels</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="index.php?action=inscription" class="f-link">Inscrire mon établissement</a>
                    <a href="index.php?action=connexion" class="f-link">Accéder à mon espace</a>
                    <a href="index.php?action=abonnements" class="f-link">Nos abonnements</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading text-uppercase mb-3">Contact</h6>
                <div class="d-flex flex-column gap-2 text-white-50 small">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-primary"></i>
                        <span>Bafoussam, Cameroun</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-telephone-fill text-primary"></i>
                        <a href="tel:+237692112388" class="f-link p-0 d-inline">+237 692 11 23 88</a>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-envelope-fill text-primary"></i>
                        <a href="mailto:contact@wonderpro.com" class="f-link p-0 d-inline">contact@wonderpro.com</a>
                    </div>
                </div>
            </div>
        </div>

   

        <div class="row align-items-center text-white-50 small">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; <?= date('Y') ?> WonderPro. Tous droits réservés.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <a href="index.php?action=mentionsLegales" class="f-link me-3 d-inline">Mentions légales</a>
                <a href="index.php?action=confidentialite" class="f-link d-inline">Confidentialité</a>
            </div>
        </div>
    </div>
</footer>

<style>
    .custom-footer {
        background: linear-gradient(180deg, #0f172a 0%, #111622 100%);
        color: #ffffff;
    }
    .footer-heading {
        color: #60a5fa !important;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 1.2px;
    }
    .footer-description { color: #94a3b8; line-height: 1.7; }
    .footer-logo-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        background: #0d6efd;
        color: #fff;
        font-weight: 800;
        font-size: 1.3rem;
        border-radius: 10px;
    }
    .footer-brand-text { font-size: 1.4rem; font-weight: 700; }
    .f-link {
        color: #cbd5e1 !important;
        text-decoration: none !important;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .f-link:hover { color: #60a5fa !important; padding-left: 4px; }
    .social-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background: rgba(255,255,255,0.08);
        color: #cbd5e1 !important;
        font-size: 1.1rem;
        text-decoration: none !important;
        transition: all 0.2s;
    }
    .social-box:hover {
        background: #0d6efd;
        color: #fff !important;
        transform: translateY(-2px);
    }
</style>
