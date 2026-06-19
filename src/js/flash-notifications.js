(function(){
    "use strict";

    function createToast(type, message) {
        var toast = document.createElement('div');
        toast.className = 'local-toast local-toast-' + type;
        toast.textContent = message;

        var close = document.createElement('button');
        close.type = 'button';
        close.className = 'local-toast-close';
        close.innerHTML = '\u00d7';
        close.onclick = function() { toast.classList.remove('show'); setTimeout(function(){ toast.remove(); }, 200); };
        toast.appendChild(close);

        document.body.appendChild(toast);
        setTimeout(function(){ toast.classList.add('show'); }, 20);
        setTimeout(function(){ toast.classList.remove('show'); setTimeout(function(){ toast.remove(); }, 200); }, 5000);
    }

    window.showLocalToast = createToast;

    document.addEventListener('DOMContentLoaded', function() {
        var data = document.getElementById('localFlashData');
        if (!data) return;
        var success = data.dataset.success;
        var error = data.dataset.error;
        if (success) createToast('success', success);
        if (error) createToast('danger', error);
    });
})();
