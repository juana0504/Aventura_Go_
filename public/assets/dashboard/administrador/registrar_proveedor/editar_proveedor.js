let currentStep = 1;

// Mostrar paso
function showStep(step) {
    const steps = document.querySelectorAll(".step-content");
    const circles = document.querySelectorAll(".step");

    steps.forEach(s => s.classList.remove("active"));
    circles.forEach(c => c.classList.remove("active"));

    document.querySelector(`.step-content[data-step="${step}"]`).classList.add("active");
    const currentCircle = document.querySelector(`.step[data-step="${step}"]`);
    if (currentCircle) currentCircle.classList.add("active");

    // Botón atrás
    document.getElementById("prevBtn").style.display = step === 1 ? "none" : "inline-block";

    const nextBtn = document.getElementById("nextBtn");

    // En paso 5 → botón se convierte en Actualizar y carga preview
    if (step === 5) {
        nextBtn.innerHTML = `Actualizar <i class="fas fa-check"></i>`;
        nextBtn.type = "submit";
        loadPreview();
    } else {
        nextBtn.innerHTML = `Siguiente <i class="fas fa-arrow-right"></i>`;
        nextBtn.type = "button";
    }
}

// Avanzar / retroceder
function changeStep(direction) {
    event.preventDefault();

    if (direction === 1 && !validateStep(currentStep)) return;

    currentStep += direction;
    if (currentStep < 1) currentStep = 1;
    if (currentStep > 5) currentStep = 5;

    showStep(currentStep);
}

// Validar campos requeridos por paso
function validateStep(step) {
    const stepContent = document.querySelector(`.step-content[data-step="${step}"]`);
    const inputs = stepContent.querySelectorAll("input[required], select[required], textarea[required]");

    for (let input of inputs) {
        if (!input.value.trim()) {
            input.classList.add("is-invalid");
            input.focus();
            return false;
        }
        input.classList.remove("is-invalid");
    }
    return true;
}

// Cargar datos en vista previa (Paso 5)
function loadPreview() {
    const val = id => document.getElementById(id)?.value || "-";

    // Empresa
    document.getElementById("prev-empresa").textContent   = val("empresa");
    document.getElementById("prev-nit").textContent       = val("nit");
    document.getElementById("prev-email").textContent     = val("email");
    document.getElementById("prev-telefono").textContent  = val("telefono");

    // Representante
    document.getElementById("prev-representante").textContent  = val("representante");
    document.getElementById("prev-email-repre").textContent    = val("email_repre");
    document.getElementById("prev-telefono-repre").textContent = val("telefono_repre");

    const tipoDoc = val("tipo_documento");
    const identi  = val("identificacion");
    document.getElementById("prev-identificacion").textContent = `${tipoDoc} · ${identi}`;

    // Actividades — renderiza como badges
    const container = document.getElementById("prev-actividades");
    container.innerHTML = "";
    const actividadesChecked = [];
    document.querySelectorAll('input[name="actividades[]"]:checked').forEach(el => actividadesChecked.push(el.value));
    if (actividadesChecked.length > 0) {
        actividadesChecked.forEach(a => {
            const span = document.createElement("span");
            span.className = "badge-servicio";
            span.style.cssText = "display:inline-block;background:rgba(234,130,23,.15);color:#ea8217;border:1px solid rgba(234,130,23,.3);border-radius:20px;padding:4px 12px;font-size:12px;font-weight:600;margin:2px";
            span.textContent = a;
            container.appendChild(span);
        });
    } else {
        container.textContent = "-";
    }

    // Ubicación
    const selectDep = document.getElementById("departamento");
    const selectCiu = document.getElementById("id_ciudad");
    const depTexto  = selectDep?.options[selectDep?.selectedIndex]?.text || "-";
    const ciudTexto = selectCiu?.options[selectCiu?.selectedIndex]?.text || "-";
    document.getElementById("prev-ubicacion").textContent  = `${depTexto} · ${ciudTexto}`;
    document.getElementById("prev-direccion").textContent  = val("direccion");
}

// Iniciar
showStep(currentStep);

// Acción del botón Next / Actualizar
document.getElementById("nextBtn").addEventListener("click", function (e) {

    // Si NO estamos en el paso final → avanzar
    if (currentStep < 5) {
        e.preventDefault();
        changeStep(1);
    }

    // Si estamos en paso 5, deja que el submit funcione normal
});
