
// Obtenemos los selects del formulario
const selectDepartamento = document.getElementById('departamento');
const selectCiudad = document.getElementById('id_ciudad');

// Cargar departamentos al iniciar la página
fetch('/aventura_go/app/controllers/departamentoController.php')
    .then(response => response.json())
    .then(data => {
        data.forEach(dep => {
            const option = document.createElement('option');
            option.value = dep.id_departamento;
            option.textContent = dep.nombre;
            selectDepartamento.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Error cargando departamentos:', error);
    });


// Al cargar la página, dejamos el select de ciudades deshabilitado
selectCiudad.disabled = true;

// Escuchamos cuando el usuario cambia el departamento
selectDepartamento.addEventListener('change', function () {

    // Obtenemos el id del departamento seleccionado
    const idDepartamento = this.value;

    // Reiniciamos el select de ciudades
    selectCiudad.innerHTML = '<option value="">Seleccione una ciudad</option>';
    selectCiudad.disabled = true;

    // Si no se seleccionó ningún departamento, no hacemos nada más
    if (!idDepartamento) {
        return;
    }

    // Llamamos al controlador que trae las ciudades desde la base de datos
    fetch(`/aventura_go/app/controllers/ciudadController.php?id_departamento=${idDepartamento}`)
        .then(response => response.json()) // Convertimos la respuesta a JSON
        .then(data => {

            // Si no vienen ciudades, dejamos el select deshabilitado
            if (data.length === 0) {
                return;
            }

            // Recorremos las ciudades recibidas
            data.forEach(ciudad => {
                const option = document.createElement('option');
                option.value = ciudad.id_ciudad; // ID real (FK)
                option.textContent = ciudad.nombre; // Nombre visible
                selectCiudad.appendChild(option);
            });

            // Habilitamos el select de ciudades
            selectCiudad.disabled = false;
        })
        .catch(error => {
            console.error('Error cargando ciudades:', error);
        });
});
