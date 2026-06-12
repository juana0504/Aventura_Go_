document.addEventListener("DOMContentLoaded", function () {

    let currentStep = 1;
    const totalSteps = 5;

    const steps        = document.querySelectorAll(".step");
    const stepContents = document.querySelectorAll(".step-content");
    const prevBtn      = document.getElementById("prevBtn");
    const nextBtn      = document.getElementById("nextBtn");
    const form         = document.getElementById("formCompletarHotelero");

    function showStep(step) {
        stepContents.forEach(c => c.classList.remove("active"));
        steps.forEach(s => { s.classList.remove("active"); s.classList.remove("completed"); });

        document.querySelector(`.step-content[data-step="${step}"]`).classList.add("active");
        document.querySelector(`.step[data-step="${step}"]`).classList.add("active");

        for (let i = 1; i < step; i++) {
            document.querySelector(`.step[data-step="${i}"]`).classList.add("completed");
        }

        prevBtn.style.display = step === 1 ? "none" : "inline-flex";

        if (step === totalSteps) {
            nextBtn.innerHTML = "Confirmar <i class='fas fa-check'></i>";
        } else {
            nextBtn.innerHTML = "Siguiente <i class='fas fa-arrow-right'></i>";
        }
    }

    showStep(currentStep);

    function showError(msg) {
        let err = document.getElementById('wiz-error');
        if (!err) {
            err = document.createElement('div');
            err.id = 'wiz-error';
            err.style.cssText = 'background:#fee2e2;color:#b91c1c;border:1px solid #fca5a5;border-radius:8px;padding:10px 16px;margin-bottom:16px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;';
            err.innerHTML = '<i class="fas fa-exclamation-circle"></i> <span></span>';
            const content = document.querySelector('.pv-wizard__content');
            content.insertBefore(err, content.firstChild);
        }
        err.querySelector('span').textContent = msg;
        err.style.display = 'flex';
        setTimeout(() => { err.style.display = 'none'; }, 4000);
    }

    function validateStep(step) {
        const hasLogo = form.dataset.hasLogo === '1';
        const hasFoto = form.dataset.hasFoto === '1';

        if (step === 1) {
            const logoInput = document.querySelector('input[name="logo"]');
            if (!hasLogo && (!logoInput || !logoInput.files || logoInput.files.length === 0)) {
                showError('Debes subir el logo del establecimiento.');
                return false;
            }
        }
        if (step === 2) {
            const habitSel = getCheckedLabels('tipo_habitacion[]');
            const pagoSel  = getCheckedLabels('metodo_pago[]');
            const servSel  = getCheckedLabels('servicio_incluido[]');
            if (!habitSel.length) { showError('Selecciona al menos un tipo de habitación.'); return false; }
            if (!pagoSel.length)  { showError('Selecciona al menos un método de pago.'); return false; }
            if (!servSel.length)  { showError('Selecciona al menos un servicio incluido.'); return false; }
        }
        if (step === 4) {
            const fotoInput = document.querySelector('input[name="foto_representante"]');
            if (!hasFoto && (!fotoInput || !fotoInput.files || fotoInput.files.length === 0)) {
                showError('Debes subir la foto del representante.');
                return false;
            }
        }
        return true;
    }

    nextBtn.addEventListener("click", function () {
        if (currentStep === totalSteps) {
            form.submit();
            return;
        }
        if (!validateStep(currentStep)) return;
        if (currentStep === 4) {
            fillPreview();
        }
        currentStep++;
        showStep(currentStep);
    });

    prevBtn.addEventListener("click", function () {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    function getCheckedLabels(name) {
        const vals = [];
        document.querySelectorAll(`input[name="${name}"]:checked`).forEach(cb => vals.push(cb.value));
        return vals;
    }

    function renderTags(containerId, values) {
        const el = document.getElementById(containerId);
        if (!el) return;
        if (!values.length) {
            el.innerHTML = '<span style="color:var(--pv-muted)">—</span>';
            return;
        }
        el.innerHTML = values.map(v => `<span>${v}</span>`).join('');
    }

    function fillPreview() {
        const val = id => (document.getElementById(id)?.value || '—');

        document.getElementById("prev-nombre_estab").innerText = val("nombre_estab");
        document.getElementById("prev-nit").innerText          = val("nit");
        document.getElementById("prev-tipo_estab").innerText   = val("tipo_estab");
        document.getElementById("prev-telefono").innerText     = val("telefono");

        renderTags("prev-habitaciones", getCheckedLabels("tipo_habitacion[]"));
        renderTags("prev-metodos",      getCheckedLabels("metodo_pago[]"));
        document.getElementById("prev-max_huesped").innerText = val("max_huesped");

        const ciudad = document.getElementById("id_ciudad");
        document.getElementById("prev-ciudad").innerText    = ciudad?.options[ciudad.selectedIndex]?.text || '—';
        document.getElementById("prev-direccion").innerText = val("direccion");

        document.getElementById("prev-representante").innerText  = val("nombre_repre");
        document.getElementById("prev-tipo_doc").innerText       = val("tipo_documento");
        document.getElementById("prev-telefono_repre").innerText = val("telefono_repre");
        document.getElementById("prev-camara").innerText         = val("camara_comercio");
        document.getElementById("prev-licencia").innerText       = val("licencia");
        renderTags("prev-servicios", getCheckedLabels("servicio_incluido[]"));
    }
});
