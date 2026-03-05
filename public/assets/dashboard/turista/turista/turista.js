const byId = (id) => document.getElementById(id);

const setupTopbarActions = () => {
    const modoOscuroBtn = byId('modoOscuroBtn');
    const notificacionesBtn = byId('notificacionesBtn');

    if (modoOscuroBtn) {
        modoOscuroBtn.addEventListener('click', (event) => {
            event.preventDefault();
            document.body.classList.toggle('modo-oscuro');
        });
    }

    if (notificacionesBtn) {
        notificacionesBtn.addEventListener('click', (event) => {
            event.preventDefault();
            alert('Tienes nuevas reservas, verifica');
        });
    }
};

document.addEventListener('DOMContentLoaded', () => {
    setupTopbarActions();
});
