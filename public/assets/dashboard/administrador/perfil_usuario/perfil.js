const modoOscuroBtn = document.getElementById('modoOscuroBtn');
const notificacionesBtn = document.getElementById('notificacionesBtn');

// Prevenir que los botones envíen el formulario
modoOscuroBtn.addEventListener('click', (e) => {
    e.preventDefault(); // ← IMPORTANTE: Previene el envío del form
    document.body.classList.toggle('modo-oscuro');
});

notificacionesBtn.addEventListener('click', (e) => {
    e.preventDefault(); // ← IMPORTANTE: Previene el envío del form
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