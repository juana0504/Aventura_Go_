


// menu hamburguesa del header____________________________________________________________________________________
const toggle = document.getElementById('menu-toggle');
const nav = document.getElementById('navbarNav');

toggle.addEventListener('click', () => {
    nav.classList.toggle('show');
});



// carrusel slick automatico__________________________________________________________________________________________
// OJO  debe cambiar el nombre del .slider-XXXXXXX las (x) es un ejemplo

$(document).ready(function () {

    $('.slider-XXXXXXXXX').slick({
        slidesToShow: 3,       // Número de cards visibles a la vez
        slidesToScroll: 1,     // Cuántas se mueven por clic
        infinite: true,        // Que sea infinito
        arrows: true,          // Muestra flechas
        dots: true,            // Muestra los puntitos de navegación
        autoplay: true,        // Activa autoplay
        autoplaySpeed: 2500,   // Velocidad del autoplay en ms
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
