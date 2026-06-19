<?php
// Protection d'accès direct
if(!isset($entreprise) || !isset($abonnement)) {
    die("Accès non autorisé");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement - WonderPro</title>
    <link rel="stylesheet" href="src/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.min.css">
    <style>
        body { background:#f5f7fb; font-family: Arial, Helvetica, sans-serif; }
        .payment-card{ border:2px solid #e8eef7;border-radius:12px;padding:16px;cursor:pointer }
        .payment-card.active{border-color:#0d6efd;background:#eef6ff}
        #payment-overlay{ position:fixed; inset:0; background:rgba(0,0,0,0.75); display:flex; align-items:center; justify-content:center; z-index:9999 }
        .overlay-panel{ max-width:460px; width:100%; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-4 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <a href="index.php?action=abonnements" class="btn btn-sm btn-outline-secondary rounded-circle me-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h4 class="mb-0">Paiement - Abonnement <?= htmlspecialchars($abonnement->id_abonnement) ?></h4>
                </div>
                <p class="mb-0 text-muted">Montant : <strong><?= number_format($abonnement->prix,0,',',' ') ?> FCFA</strong></p>
            </div>

            <div class="card shadow-sm border-0 p-4">
                <form id="payment-form" action="index.php?action=validerPaiement" method="POST" novalidate>
                    <input type="hidden" name="id_abonnement" value="<?= htmlspecialchars($abonnement->id_abonnement) ?>">
                    <input type="hidden" name="montant" value="<?= htmlspecialchars($abonnement->prix) ?>">

                    <div class="mb-3">
                        <label class="form-label">Mode de paiement</label>
                        <div class="d-flex gap-3">
                            <label class="payment-card active" data-mode="Orange Money">
                                <input type="radio" name="mode_paiement" value="Orange Money" checked hidden>
                                <div class="text-center">
                                    <i class="bi bi-phone text-warning" style="font-size:2rem"></i>
                                    <div class="mt-2">Orange Money</div>
                                </div>
                            </label>
                            <label class="payment-card" data-mode="MTN Mobile Money">
                                <input type="radio" name="mode_paiement" value="MTN Mobile Money" hidden>
                                <div class="text-center">
                                    <i class="bi bi-phone text-success" style="font-size:2rem"></i>
                                    <div class="mt-2">MTN MoMo</div>
                                </div>
                            </label>
                            <label class="payment-card" data-mode="Carte Bancaire">
                                <input type="radio" name="mode_paiement" value="Carte Bancaire" hidden>
                                <div class="text-center">
                                    <i class="bi bi-credit-card-2-back-fill fs-2 text-primary"></i>
                                    <div class="mt-2">Carte Bancaire</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="momo-fields" class="mb-3">
                        <label class="form-label">Numéro Mobile Money <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">+237</span>
                            <input name="momo_phone" id="momo_phone" type="tel" class="form-control" placeholder="6xxxxxxxx" required>
                        </div>
                    </div>

                    <div id="card-fields" class="mb-3 d-none">
                        <label class="form-label">Informations carte</label>
                        <input name="card_name" id="card_name" class="form-control mb-2" placeholder="Nom du titulaire">
                        <input name="card_number" id="card_number" class="form-control mb-2" placeholder="Numéro de carte">
                        <div class="d-flex gap-2">
                            <input name="card_expiry" id="card_expiry" class="form-control" placeholder="MM/AA">
                            <input name="card_cvv" id="card_cvv" class="form-control" placeholder="CVV">
                        </div>
                    </div>

                    <div class="d-grid mt-3">
                        <button id="start-sim" type="button" class="btn btn-primary btn-lg">Valider le paiement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Overlay -->
<div id="payment-overlay" class="d-none">
    <div class="overlay-panel bg-white p-4 rounded">
        <div id="overlay-loader" class="text-center">
            <div class="spinner-border text-primary mb-3" role="status"></div>
            <h5 id="overlay-title">Traitement...</h5>
            <p id="overlay-desc" class="text-muted">Veuillez patienter pendant la simulation.</p>
        </div>

        <div id="overlay-ref" class="d-none">
            <label class="form-label">Référence de transaction</label>
            <input id="transaction_reference" class="form-control mb-3" maxlength="50" placeholder="Entrez la référence fournie par l'opérateur">
            <div class="text-danger small d-none" id="ref-error">La référence est requise.</div>
            <div class="d-grid">
                <button id="confirm-ref" class="btn btn-success">Valider référence</button>
            </div>
        </div>

        <div id="overlay-success" class="d-none text-center">
            <div class="mb-3 text-success"><i class="bi bi-check-circle-fill fs-1"></i></div>
            <h5>Paiement simulé avec succès</h5>
            <p class="text-muted" id="success-txt"></p>
        </div>
    </div>
</div>

<script>
// Vanilla JS to avoid jQuery dependency issues
document.addEventListener('DOMContentLoaded', function(){
    var cards = document.querySelectorAll('.payment-card');
    var momoFields = document.getElementById('momo-fields');
    var cardFields = document.getElementById('card-fields');
    var startBtn = document.getElementById('start-sim');
    var overlay = document.getElementById('payment-overlay');
    var overlayLoader = document.getElementById('overlay-loader');
    var overlayRef = document.getElementById('overlay-ref');
    var overlaySuccess = document.getElementById('overlay-success');
    var confirmRef = document.getElementById('confirm-ref');
    var refInput = document.getElementById('transaction_reference');
    var refError = document.getElementById('ref-error');
    var paymentForm = document.getElementById('payment-form');

    function setActive(card){
        cards.forEach(function(c){ c.classList.remove('active'); });
        card.classList.add('active');
        var mode = card.getAttribute('data-mode');
        if(mode === 'Carte Bancaire'){
            momoFields.classList.add('d-none');
            cardFields.classList.remove('d-none');
            // set required attributes
            document.getElementById('momo_phone').required = false;
        } else {
            momoFields.classList.remove('d-none');
            cardFields.classList.add('d-none');
            document.getElementById('momo_phone').required = true;
        }
        // Set radio checked
        var radio = card.querySelector('input[type=radio]');
        if(radio) radio.checked = true;
    }

    cards.forEach(function(card){
        card.addEventListener('click', function(){ setActive(card); });
    });

    // Start simulation
    startBtn.addEventListener('click', function(){
        // validate visible inputs
        if(!paymentForm.checkValidity()){
            paymentForm.reportValidity();
            return;
        }
        overlay.classList.remove('d-none');
        overlayLoader.classList.remove('d-none');
        overlayRef.classList.add('d-none');
        overlaySuccess.classList.add('d-none');
        document.getElementById('overlay-title').textContent = 'Validation du paiement...';
        // Simulate processing time then ask for reference
        setTimeout(function(){
            overlayLoader.classList.add('d-none');
            overlayRef.classList.remove('d-none');
        }, 1200);
    });

    confirmRef.addEventListener('click', function(){
        var ref = refInput.value.trim();
        if(ref === ''){ refError.classList.remove('d-none'); return; }
        refError.classList.add('d-none');
        overlayRef.classList.add('d-none');
        overlaySuccess.classList.remove('d-none');
        document.getElementById('success-txt').textContent = 'Référence : ' + ref;
        // append hidden input and submit after small delay
        setTimeout(function(){
            var inp = document.createElement('input');
            inp.type = 'hidden'; inp.name = 'reference'; inp.value = ref;
            paymentForm.appendChild(inp);
            paymentForm.submit();
        }, 900);
    });

    // close overlay when clicking outside panel
    overlay.addEventListener('click', function(e){
        if(e.target === overlay){ overlay.classList.add('d-none'); }
    });
});
</script>
</body>
</html>
