//menu hamburguesa
document.addEventListener("DOMContentLoaded", function () {

    const menuToggle = document.querySelector(".menu-toggle");
    const navMenu = document.querySelector(".navbar-nav");

    // Abrir / cerrar menú
    menuToggle.addEventListener("click", function () {
        navMenu.classList.toggle("active");
    });

    // Cerrar menú al hacer clic en un enlace
    const navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach(link => {
        link.addEventListener("click", () => {
            navMenu.classList.remove("active");
        });
    });

});



// Dropdown perfil
const profileToggle = document.getElementById('profileToggle');
const profileMenu = document.getElementById('profileMenu');

if (profileToggle && profileMenu) {

    profileToggle.addEventListener('click', function (e) {
        e.stopPropagation();

        profileMenu.style.display =
            profileMenu.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function () {
        profileMenu.style.display = 'none';
    });

}

// Carrusel de las imagenes

const track = document.querySelector(".carousel-track");
const images = document.querySelectorAll(".carousel-track img");
const items = document.querySelectorAll(".item");
const next = document.querySelector(".next");
const prev = document.querySelector(".prev");
const carousel = document.querySelector(".cont-img-principal");

let index = 0;

function moveCarousel(i) {
    track.style.transform = `translateX(-${i * 100}%)`;

    items.forEach(b => b.classList.remove("active"));
    items[i].classList.add("active");

    index = i;
}


