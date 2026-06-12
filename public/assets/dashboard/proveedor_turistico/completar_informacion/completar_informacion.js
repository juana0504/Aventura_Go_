document.addEventListener("DOMContentLoaded", function () {

    let currentStep = 1;
    const totalSteps = 5;

    const steps = document.querySelectorAll(".step");
    const stepContents = document.querySelectorAll(".step-content");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const form = document.getElementById("formCompletarProveedor");
    function showStep(step) {
        // Ocultar todo
        stepContents.forEach(c => c.classList.remove("active"));
        steps.forEach(s => s.classList.remove("active"));

        // Mostrar actual
        document.querySelector(`.step-content[data-step="${step}"]`).classList.add("active");
        document.querySelector(`.step[data-step="${step}"]`).classList.add("active");

        // Botones
        if (step === 1) {
            prevBtn.style.display = "none";
        } else {
            prevBtn.style.display = "inline-block";
        }

        if (step === totalSteps) {
            nextBtn.innerHTML = "Confirmar <i class='fas fa-check'></i>";
        } else {
            nextBtn.innerHTML = "Siguiente <i class='fas fa-arrow-right'></i>";
        }
    }

    // Inicializar
    showStep(currentStep);

    function stepError(msg) {
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
        if (step === 1) {
            const logo = document.getElementById('logo');
            const hasLogo = form.dataset.hasLogo === '1';
            if (!hasLogo && (!logo || !logo.files || logo.files.length === 0)) {
                stepError('Debes subir el logo de tu empresa.'); return false;
            }
        }
        if (step === 2) {
            const actSel = document.querySelectorAll('input[name="actividades[]"]:checked');
            if (!actSel.length) { stepError('Selecciona al menos una actividad.'); return false; }
            if (!document.getElementById('descripcion')?.value.trim()) {
                stepError('Completa la descripción de la empresa.'); return false;
            }
        }
        if (step === 3) {
            if (!document.getElementById('departamento')?.value) {
                stepError('Selecciona un departamento.'); return false;
            }
            if (!document.getElementById('id_ciudad')?.value) {
                stepError('Selecciona una ciudad.'); return false;
            }
            if (!document.getElementById('direccion')?.value.trim()) {
                stepError('Ingresa la dirección.'); return false;
            }
        }
        if (step === 4) {
            const foto = document.getElementById('foto_representante');
            const hasFoto = form.dataset.hasFoto === '1';
            if (!hasFoto && (!foto || !foto.files || foto.files.length === 0)) {
                stepError('Debes subir la foto del representante.'); return false;
            }
        }
        return true;
    }

    // Siguiente
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

    // Anterior
    prevBtn.addEventListener("click", function () {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // Llenar preview
    function fillPreview() {
        document.getElementById("prev-empresa").innerText = document.getElementById("empresa").value || "-";
        document.getElementById("prev-nit").innerText = document.getElementById("nit").value || "-";
        document.getElementById("prev-email").innerText = document.getElementById("email").value || "-";
        document.getElementById("prev-telefono").innerText = document.getElementById("telefono").value || "-";

        document.getElementById("prev-email_repre").innerText = document.getElementById("email_repre").value || "-";
        document.getElementById("prev-telefono_repre").innerText = document.getElementById("telefono_repre").value || "-";
        document.getElementById("prev-representante").innerText = document.getElementById("nombre_repre").value || "-";
        document.getElementById("prev-descripcion").innerText = document.getElementById("descripcion").value || "-";
    
        // Actividades
        const actividades = [];
        document.querySelectorAll('input[name="actividades[]"]:checked').forEach(cb => {
            actividades.push(cb.value);
        });
        document.getElementById("prev-actividades").innerText = actividades.length ? actividades.join(", ") : "-";

        // Ubicación
        const ciudad = document.getElementById("id_ciudad");
        const ciudadTexto = ciudad.options[ciudad.selectedIndex]?.text || "-";
        document.getElementById("prev-ubicacion").innerText = ciudadTexto;
        const direccion = document.getElementById("direccion").value || "-";
        document.getElementById("prev-direccion").innerText = direccion;
    }

});