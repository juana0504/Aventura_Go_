
// Inicializar DataTable
$(document).ready(function () {
    $('#tablaAdmin').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        dom: 'Bfrtip',
        buttons: [{
            extend: 'copy',
            text: '<i class="bi bi-clipboard"></i> Copiar',
            className: 'btn-export'
        },
        {
            extend: 'excel',
            text: '<i class="bi bi-file-excel"></i> Excel',
            className: 'btn-export'
        },
        {
            extend: 'pdf',
            text: '<i class="bi bi-file-pdf"></i> PDF',
            className: 'btn-export'
        },
        {
            extend: 'print',
            text: '<i class="bi bi-printer"></i> Imprimir',
            className: 'btn-export'
        }
        ],
        pageLength: 10,
        responsive: true
    });
});

// Filtros rápidos
document.querySelectorAll('.filtro-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const filter = this.getAttribute('data-filter');
        const table = $('#tablaAdmin').DataTable();

        if (filter === 'all') {
            table.search('').draw();
        } else {
            table.search(filter).draw();
        }
    });
});

// Botones de acción
document.querySelectorAll('.btn-eliminar').forEach(btn => {
    btn.addEventListener('click', function () {
        if (confirm('¿Estás seguro de eliminar este registro?')) {
            // Aquí iría la lógica de eliminación
            alert('Registro eliminado');
        }
    });
});
