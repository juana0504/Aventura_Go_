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

    // Siguiente
    nextBtn.addEventListener("click", function () {
        if (currentStep === totalSteps) {
            form.submit(); // ahora sí envía
            return;
        }

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

        document.getElementById("prev-nombre_repre").innerText = document.getElementById("nombre_repre").value || "-";
        document.getElementById("prev-email_repre").innerText = document.getElementById("email_repre").value || "-";
        document.getElementById("prev-telefono_repre").innerText = document.getElementById("telefono_repre").value || "-";
        document.getElementById("prev-representante").innerText = document.getElementById("nombre_repre").value || "-";
        
        // const descripcion = document.getElementById("descripcion");
        // const prevDescripcion = document.getElementById("prev-descripcion");

        // if (prevDescripcion && descripcion) {
        //     prevDescripcion.textContent = descripcion.value.trim() !== "" ? descripcion.value : "-";
        // }

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
    }

});