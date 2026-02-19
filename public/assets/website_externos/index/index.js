// menu hamburguesa
const toggle = document.getElementById('menu-toggle');
const nav = document.getElementById('navbarNav');

toggle.addEventListener('click', () => {
    nav.classList.toggle('show');
});

// carrusel slick automatico
$(document).ready(function () {

    $('.slider-testimonios').slick({
        slidesToShow: 3,       // Número de cards visibles a la vez
        slidesToScroll: 1,     // Cuántas se mueven por clic
        infinite: true,        // Que sea infinito
        arrows: true,          // Muestra flechas
        dots: true,            // Muestra los puntitos de navegación
        autoplay: true,        // Activa autoplay
        autoplaySpeed: 1500,   // Velocidad del autoplay en ms
        responsive: [
            {
                breakpoint: 1024, // Tablets y laptops pequeñas
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 768, // Celulares grandes
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

});

// para el dropdown
    const profileToggle = document.getElementById('profileToggle');
    const profileMenu = document.getElementById('profileMenu');

    if (profileToggle) {
        profileToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            profileMenu.style.display =
                profileMenu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function () {
            profileMenu.style.display = 'none';
        });
    }
document.addEventListener('DOMContentLoaded', function () {
    const inputBuscador = document.querySelector('.buscador input');

    // Elementos que quieres que sean buscables — ajusta el selector a tu contenido
    const elementosBuscables = document.querySelectorAll('.card, .actividad, .destino, .tour-item');

    function buscar(termino) {
        const texto = termino.toLowerCase().trim();

        elementosBuscables.forEach(el => {
            const contenido = el.textContent.toLowerCase();
            if (texto === '' || contenido.includes(texto)) {
                el.style.display = '';
                el.style.opacity = '1';
            } else {
                el.style.display = 'none';
                el.style.opacity = '0';
            }
        });

        // Mensaje si no hay resultados
        let noResultados = document.querySelector('.buscador-sin-resultados');
        const hayResultados = [...elementosBuscables].some(el => el.style.display !== 'none');

        if (!hayResultados && texto !== '') {
            if (!noResultados) {
                noResultados = document.createElement('p');
                noResultados.classList.add('buscador-sin-resultados');
                noResultados.style.cssText = 'color:#EA8217; margin-top:12px; font-family:Lato,sans-serif;';
                noResultados.textContent = 'No se encontraron resultados.';
                // Inserta el mensaje después del contenedor padre de los elementos buscables
                elementosBuscables[0]?.parentElement?.after(noResultados);
            }
        } else if (noResultados) {
            noResultados.remove();
        }
    }

    // Busca mientras escribe
    inputBuscador?.addEventListener('input', function () {
        buscar(this.value);
    });

    // Busca al presionar Enter
    inputBuscador?.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            buscar(this.value);
        }
    });

    // Click en la lupa también dispara la búsqueda
    document.querySelector('.buscador i')?.addEventListener('click', function () {
        buscar(inputBuscador.value);
        inputBuscador.focus();
    });
});



document.addEventListener('DOMContentLoaded', function () {
    const buscador = document.querySelector('.buscador');
    const lupa = document.querySelector('.buscador i');
    const input = document.querySelector('.buscador input');

    // Animación suave con translateX
    buscador.addEventListener('mouseenter', moverLupaIzquierda);
    buscador.addEventListener('focusin', moverLupaIzquierda);
    buscador.addEventListener('mouseleave', moverLupaDerecha);
    buscador.addEventListener('focusout', moverLupaDerecha);

    function moverLupaIzquierda() {
    lupa.style.transform = `translateX(0px) translateY(0px)`;
    /* ^^^ sube o baja este número hasta donde quieras que llegue */
    lupa.style.color = '#d96f12';
}

function moverLupaDerecha() {
    lupa.style.transform = `translateX(170px) translateY(0px)`;
    lupa.style.color = '#EA8217';
}

    // Click en lupa también dispara búsqueda
    lupa.addEventListener('click', function () {
        buscar(input.value);
        input.focus();
    });
});