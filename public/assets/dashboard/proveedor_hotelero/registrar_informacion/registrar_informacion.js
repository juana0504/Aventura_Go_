document.addEventListener("DOMContentLoaded", function () {

    let currentStep = 1;
    const totalSteps = 6;

    const steps = document.querySelectorAll(".step");
    const stepContents = document.querySelectorAll(".step-content");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const form = document.getElementById("formProveedor");

    // Evita submit automático del navegador
    form.addEventListener("submit", function(e){
        e.preventDefault();
    });

    // Toggle sidebar
    const btnMenu = document.getElementById("btnMenu");
    const sidebar = document.querySelector(".sidebar");

    if (btnMenu && sidebar) {
        btnMenu.addEventListener("click", () => {
            sidebar.classList.toggle("activo");
        });
    }

    function showStep(step){

        stepContents.forEach(content => content.classList.remove("active"));
        steps.forEach(stepItem => stepItem.classList.remove("active"));

        document.querySelector(`.step-content[data-step="${step}"]`).classList.add("active");
        document.querySelector(`.step[data-step="${step}"]`).classList.add("active");

        prevBtn.style.display = (step === 1) ? "none" : "inline-block";

        if(step === totalSteps){
            nextBtn.innerHTML = "Finalizar registro <i class='fas fa-check'></i>";
        }else{
            nextBtn.innerHTML = "Siguiente <i class='fas fa-arrow-right'></i>";
        }
    }

    showStep(currentStep);

    // 🔥 VALIDACIÓN CORRECTA POR PASO
    function validarPasoActual() {
        const currentStepContent = document.querySelector(`.step-content[data-step="${currentStep}"]`);
        const inputs = currentStepContent.querySelectorAll("input, select, textarea");

        for (let input of inputs) {

            // Ignorar inputs ocultos (de otros pasos)
            if (input.offsetParent === null) continue;

            if (!input.checkValidity()) {
                input.reportValidity();
                return false;
            }
        }

        return true;
    }

    nextBtn.addEventListener("click", function(){

        // Validar solo el paso actual
        if (!validarPasoActual()) return;

        // Último paso → enviar
        if(currentStep === totalSteps){
            form.submit();
            return;
        }

        // Llenar preview antes del paso 6
        if(currentStep === 5){
            try{
                llenarPreview();
            }catch(e){
                console.error("Error llenando preview:", e);
            }
        }

        currentStep++;
        showStep(currentStep);
    });

    prevBtn.addEventListener("click", function(){
        if(currentStep > 1){
            currentStep--;
            showStep(currentStep);
        }
    });

    function obtenerCheckbox(name){
        const seleccionados = [];
        document.querySelectorAll(`input[name="${name}"]:checked`).forEach(cb => {
            seleccionados.push(cb.value);
        });
        return seleccionados.length ? seleccionados.join(", ") : "-";
    }

    function llenarPreview(){

        document.getElementById("preview_nombre_establecimiento").innerText =
        document.getElementById("nombre_establecimiento").value || "-";

        document.getElementById("preview_email").innerText =
        document.getElementById("email").value || "-";

        document.getElementById("preview_telefono").innerText =
        document.getElementById("telefono").value || "-";

        document.getElementById("preview_tipo_establecimiento").innerText =
        obtenerCheckbox("tipo_establecimiento[]");

        document.getElementById("preview_nombre_representante").innerText =
        document.getElementById("nombre_repre").value || "-";

        const tipoDoc = document.getElementById("tipo_documento");
        document.getElementById("preview_tipo_documento").innerText =
        tipoDoc.options[tipoDoc.selectedIndex]?.text || "-";

        document.getElementById("preview_identificacion_representante").innerText =
        document.getElementById("identificacion_repre").value || "-";

        document.getElementById("preview_email_representante").innerText =
        document.getElementById("email_repre").value || "-";

        document.getElementById("preview_telefono_representante").innerText =
        document.getElementById("telefono_repre").value || "-";

        const departamento = document.getElementById("departamento");
        const ciudad = document.getElementById("id_ciudad");

        document.getElementById("preview_departamento").innerText =
        departamento.options[departamento.selectedIndex]?.text || "-";

        document.getElementById("preview_ciudad").innerText =
        ciudad.options[ciudad.selectedIndex]?.text || "-";

        document.getElementById("preview_direccion").innerText =
        document.getElementById("direccion").value || "-";

        document.getElementById("preview_tipo_habitacion").innerText =
        obtenerCheckbox("tipo_habitacion[]");

        document.getElementById("preview_max_huesped").innerText =
        document.getElementById("max_huesped").value || "-";

        document.getElementById("preview_servicio_incluido").innerText =
        obtenerCheckbox("servicio_incluido[]");

        document.getElementById("preview_nit_rut").innerText =
        document.getElementById("nit_rut").value || "-";

        document.getElementById("preview_camara_comercio").innerText =
        document.getElementById("camara_comercio").value || "-";

        document.getElementById("preview_licencia").innerText =
        document.getElementById("licencia").value || "-";

        document.getElementById("preview_metodo_pago").innerText =
        obtenerCheckbox("metodo_pago[]");
    }

});