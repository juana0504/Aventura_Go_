document.addEventListener("DOMContentLoaded", function () {

    let currentStep = 1;
    const totalSteps = 6;

    const steps = document.querySelectorAll(".step");
    const stepContents = document.querySelectorAll(".step-content");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const form = document.getElementById("formProveedor");

    // Toggle sidebar
    const btnMenu = document.getElementById("btnMenu");
    const sidebar = document.querySelector(".sidebar");
    
    if (btnMenu && sidebar) {
        btnMenu.addEventListener("click", () => {
            sidebar.classList.toggle("activo");
        });
    }


    function showStep(step){

        stepContents.forEach(content => {
            content.classList.remove("active");
        });

        steps.forEach(stepItem => {
            stepItem.classList.remove("active");
        });

        document.querySelector(`.step-content[data-step="${step}"]`).classList.add("active");
        document.querySelector(`.step[data-step="${step}"]`).classList.add("active");


        if(step === 1){
            prevBtn.style.display = "none";
        }else{
            prevBtn.style.display = "inline-block";
        }


        if(step === totalSteps){
            nextBtn.innerHTML = "Finalizar registro <i class='fas fa-check'></i>";
        }else{
            nextBtn.innerHTML = "Siguiente <i class='fas fa-arrow-right'></i>";
        }

    }


    showStep(currentStep);


    nextBtn.addEventListener("click", function(){

        if(currentStep === totalSteps){
            form.submit();
            return;
        }

        if(currentStep === 5){ // Antes de mostrar el paso 6, llenamos el preview
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

        // PASO 1
        document.getElementById("preview_nombre_establecimiento").innerText =
        document.getElementById("nombre_establecimiento").value || "-";

        document.getElementById("preview_email").innerText =
        document.getElementById("email").value || "-";

        document.getElementById("preview_telefono").innerText =
        document.getElementById("telefono").value || "-";

        document.getElementById("preview_tipo_establecimiento").innerText =
        obtenerCheckbox("tipo_establecimiento[]");


        // PASO 2
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


        // PASO 3
        const departamento = document.getElementById("departamento");
        const ciudad = document.getElementById("id_ciudad");

        document.getElementById("preview_departamento").innerText =
        departamento.options[departamento.selectedIndex]?.text || "-";

        document.getElementById("preview_ciudad").innerText =
        ciudad.options[ciudad.selectedIndex]?.text || "-";

        document.getElementById("preview_direccion").innerText =
        document.getElementById("direccion").value || "-";


        // PASO 4
        document.getElementById("preview_tipo_habitacion").innerText =
        obtenerCheckbox("tipo_habitacion[]");

        document.getElementById("preview_max_huesped").innerText =
        document.getElementById("max_huesped").value || "-";

        document.getElementById("preview_servicio_incluido").innerText =
        obtenerCheckbox("servicio_incluido[]");


        // PASO 5
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