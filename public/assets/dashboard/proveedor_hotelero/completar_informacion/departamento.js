
// Obtenemos los selects del formulario
const selectDepartamento = document.getElementById('departamento');
const selectCiudad = document.getElementById('id_ciudad');

// Cargar departamentos al iniciar la página
fetch(BASE_URL + 'departamentos')
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


// Escuchamos cuando el usuario cambia el departamento
selectDepartamento.addEventListener('change', function () {

    const idDepartamento = this.value;

    // Limpiar ciudades anteriores
    selectCiudad.innerHTML = '<option value="">Seleccione una ciudad</option>';

    if (!idDepartamento) return;

    fetch(BASE_URL + `ciudades?id_departamento=${idDepartamento}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(ciudad => {
                const option = document.createElement('option');
                option.value = ciudad.id_ciudad;
                option.textContent = ciudad.nombre;
                selectCiudad.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error cargando ciudades:', error);
        });
});
