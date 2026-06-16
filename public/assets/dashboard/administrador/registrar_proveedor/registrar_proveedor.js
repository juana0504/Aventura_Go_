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

    // Si es el paso final → pasa a "Registrar"
    if (step == 5) {
        nextBtn.innerHTML = `Registrar <i class="fas fa-check"></i>`;
        nextBtn.type = "submit"; // ✅ Aquí ya envía
        loadPreview(); // ✅ cargar vista previa
    } else {
        nextBtn.innerHTML = `Siguiente <i class="fas fa-arrow-right"></i>`;
        nextBtn.type = "button"; // ✅ NO envía aún
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
    document.getElementById("prev-empresa").textContent = empresa.value;
    document.getElementById("prev-nit").textContent = nit.value;
    document.getElementById("prev-email").textContent = email.value;
    document.getElementById("prev-telefono").textContent = telefono.value;

    const logoEl = document.getElementById('logo');
    document.getElementById("prev-logo").textContent = logoEl && logoEl.files[0] ? logoEl.files[0].name : 'Sin archivo seleccionado';

    let actividades = [];
    document.querySelectorAll('input[name="actividades[]"]:checked').forEach(el => actividades.push(el.value));
    document.getElementById("prev-actividades").textContent = actividades.join(", ") || "-";

    const ciudadSel = document.getElementById('id_ciudad');
    const deptSel = document.getElementById('departamento');
    const ciudadNombre = ciudadSel && ciudadSel.selectedIndex > 0 ? ciudadSel.options[ciudadSel.selectedIndex].text : '-';
    const deptNombre = deptSel && deptSel.selectedIndex > 0 ? deptSel.options[deptSel.selectedIndex].text : '-';
    document.getElementById("prev-ubicacion").textContent = `${deptNombre}, ${ciudadNombre}`;
    document.getElementById("prev-direccion").textContent = document.getElementById('direccion')?.value || '-';

    document.getElementById("prev-nombre_repre").textContent = nombre_repre.value;
    document.getElementById("prev-email_repre").textContent = email_repre.value;
    document.getElementById("prev-telefono_repre").textContent = telefono_repre.value;
    const tipoDocEl = document.getElementById('tipo_documento');
    document.getElementById("prev-tipo_doc").textContent = tipoDocEl ? tipoDocEl.value : '-';
    document.getElementById("prev-identificacion").textContent = document.getElementById('identiificacion_repre')?.value || '-';
    const fotoEl = document.getElementById('foto_representante');
    document.getElementById("prev-foto").textContent = fotoEl && fotoEl.files[0] ? fotoEl.files[0].name : 'Sin archivo seleccionado';
}

// Iniciar
showStep(currentStep);

// Acción del botón Next / Registrar
document.getElementById("nextBtn").addEventListener("click", function (e) {
    // Si NO estamos en el paso final → avanzar
    if (currentStep < 5) {
        e.preventDefault();
        changeStep(1);
    }
    // Si estamos en paso 4, deja que el submit funcione normal ✅
});
