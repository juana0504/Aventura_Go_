const datosColombia = {
    "Antioquia": ["Medellín", "Envigado", "Bello", "Itagüí", "Rionegro"],
    "Atlántico": ["Barranquilla", "Soledad", "Malambo"],
    "Bogotá D.C.": ["Bogotá"],
    "Bolívar": ["Cartagena", "Magangué"],
    "Boyacá": ["Tunja", "Duitama", "Sogamoso"],
    "Caldas": ["Manizales", "Chinchiná"],
    "Cauca": ["Popayán"],
    "Cesar": ["Valledupar"],
    "Córdoba": ["Montería"],
    "Cundinamarca": ["Soacha", "Chía", "Zipaquirá"],
    "Huila": ["Neiva"],
    "Magdalena": ["Santa Marta"],
    "Meta": ["Villavicencio"],
    "Nariño": ["Pasto", "Ipiales"],
    "Norte de Santander": ["Cúcuta"],
    "Quindío": ["Armenia"],
    "Risaralda": ["Pereira", "Dosquebradas"],
    "Santander": ["Bucaramanga", "Floridablanca"],
    "Sucre": ["Sincelejo"],
    "Tolima": ["Ibagué"],
    "Valle del Cauca": ["Cali", "Palmira", "Buenaventura"]
};

const selectDepto = document.getElementById("departamento");
const selectCiudad = document.getElementById("ciudad");

// función cargar ciudades
function cargarCiudades(depto, ciudadSeleccionada = null) {
    selectCiudad.innerHTML = '<option value="">Seleccione una ciudad</option>';
    selectCiudad.disabled = true;

    if (!datosColombia[depto]) return;

    datosColombia[depto].forEach(ciudad => {
        const option = document.createElement("option");
        option.value = ciudad;
        option.textContent = ciudad;

        if (ciudadSeleccionada && ciudad === ciudadSeleccionada) {
            option.selected = true;
        }

        selectCiudad.appendChild(option);
    });

    selectCiudad.disabled = false;
}

// 🔹 cargar departamentos (SIEMPRE)
selectDepto.innerHTML = '<option value="">Seleccione un departamento</option>';
for (const depto in datosColombia) {
    const option = document.createElement("option");
    option.value = depto;
    option.textContent = depto;
    selectDepto.appendChild(option);
}

// 🔹 SOLO si es editar
if (typeof departamentoActual !== "undefined" && departamentoActual) {
    selectDepto.value = departamentoActual;
    cargarCiudades(departamentoActual, ciudadActual);
}

// 🔹 cuando cambia departamento
selectDepto.addEventListener("change", function () {
    cargarCiudades(this.value);
});
