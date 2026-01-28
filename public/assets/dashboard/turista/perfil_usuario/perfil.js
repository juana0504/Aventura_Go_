const modoOscuroBtn = document.getElementById('modoOscuroBtn');
const notificacionesBtn = document.getElementById('notificacionesBtn');

// Prevenir que los botones envíen el formulario
modoOscuroBtn.addEventListener('click', (e) => {
    e.preventDefault();
    document.body.classList.toggle('modo-oscuro');
});

notificacionesBtn.addEventListener('click', (e) => {
    e.preventDefault();
    alert("Tienes nuevas reservas, verifica");
});


document.addEventListener("DOMContentLoaded", () =>{
    const secciones = {
        descripcion : document.querySelector(".datos"),
        editar : document.querySelector(".editar"),
        cambiar : document.querySelector(".cambiar")
    };

    // Botones 
    document.getElementById("btndescripcion").addEventListener('click', () => mostrarSeccion ("descripcion"));
    document.getElementById("btneditar").addEventListener('click', () => mostrarSeccion ("editar"));
    document.getElementById("btncambiar").addEventListener('click', () => mostrarSeccion ("cambiar"));

    function mostrarSeccion(nombre){
        for(let key in secciones){
            secciones[key].classList.remove("activa");
        }
        secciones[nombre].classList.add("activa");
    }

    mostrarSeccion("descripcion");
});


// ---------------------------------------------------------------------
// ✅ OJITOS – Mostrar / ocultar contraseña (FUNCIONA EN LOS 3 CAMPOS)
// ---------------------------------------------------------------------
document.querySelectorAll(".togglePassword").forEach(icon => {
    icon.addEventListener("click", () => {
        const inputID = icon.getAttribute("data-input");
        const input = document.getElementById(inputID);

        // Cambiar tipo password/text
        input.type = input.type === "password" ? "text" : "password";

        // Animar el ojito
        icon.classList.toggle("bi-eye-fill");
        icon.classList.toggle("bi-eye-slash-fill");
    });
});
