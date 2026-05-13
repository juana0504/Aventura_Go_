document.addEventListener("DOMContentLoaded", function () {
    
// Obtenemos los selects del formulario
const selectDepartamento = document.getElementById('departamento');
const selectCiudad = document.getElementById('id_ciudad');

//ojo SOLO para pruebas
// console.log(selectDepartamento);
// console.log(selectCiudad);

// Cargar departamentos al iniciar la página
fetch(BASE_URL + 'departamentos')
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
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
fetch(BASE_URL + `ciudades?id_departamento=${idDepartamento}`)
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al cargar ciudades');
        }
        return response.json();
    })
    .then(data => {

            // Si no vienen ciudades, dejamos el select deshabilitado
           if (data.length === 0) {
            const option = document.createElement('option');
            option.textContent = 'No hay ciudades disponibles';
            option.value = '';
            selectCiudad.appendChild(option);
             selectCiudad.disabled = false; // Aunque no hay ciudades, permitimos que el usuario vea el mensaje
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


});



