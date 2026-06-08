document.addEventListener('DOMContentLoaded', () => {
    const oldDarkBtn = document.getElementById('modoOscuroBtn');
    const oldNotifBtn = document.getElementById('notificacionesBtn');

    if (oldDarkBtn) {
        oldDarkBtn.addEventListener('click', (e) => {
            e.preventDefault();
            document.body.classList.toggle('modo-oscuro');
        });
    }

    if (oldNotifBtn) {
        oldNotifBtn.addEventListener('click', (e) => {
            e.preventDefault();
            alert('Tienes nuevas reservas, verifica');
        });
    }

    // Compatibilidad con layouts legacy
    const secciones = {
        descripcion: document.querySelector('.datos'),
        editar: document.querySelector('.editar'),
        cambiar: document.querySelector('.cambiar')
    };

    const btnDescripcion = document.getElementById('btndescripcion');
    const btnEditar = document.getElementById('btneditar');
    const btnCambiar = document.getElementById('btncambiar');

    const mostrarSeccion = (nombre) => {
        Object.keys(secciones).forEach((key) => {
            if (secciones[key]) {
                secciones[key].classList.remove('activa');
            }
        });

        if (secciones[nombre]) {
            secciones[nombre].classList.add('activa');
        }
    };

    if (btnDescripcion && btnEditar && btnCambiar) {
        btnDescripcion.addEventListener('click', () => mostrarSeccion('descripcion'));
        btnEditar.addEventListener('click', () => mostrarSeccion('editar'));
        btnCambiar.addEventListener('click', () => mostrarSeccion('cambiar'));
        mostrarSeccion('descripcion');
    }

    // Ojos de contraseña en vistas nuevas y legacy
    document.querySelectorAll('.togglePassword, .adm-pf-toggle-pw').forEach((icon) => {
        icon.addEventListener('click', () => {
            const inputID = icon.getAttribute('data-input');
            const input = document.getElementById(inputID);
            if (!input) return;

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            icon.classList.toggle('bi-eye-fill', !isPassword);
            icon.classList.toggle('bi-eye-slash-fill', isPassword);
        });
    });

    // Preview de foto para edición de perfil
    const fileInput = document.getElementById('foto');
    const editPreview = document.getElementById('adm-pf-edit-preview');
    const cardPreview = document.getElementById('adm-pf-preview');
    const topbarAvatars = document.querySelectorAll('.adm-profile-btn__avatar-img');

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            if (!this.files || !this.files[0]) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                const src = e.target && e.target.result ? e.target.result : '';
                if (!src) return;
                if (editPreview) editPreview.src = src;
                if (cardPreview) cardPreview.src = src;
                topbarAvatars.forEach((img) => {
                    img.src = src;
                });
            };
            reader.readAsDataURL(this.files[0]);
        });
    }
});
