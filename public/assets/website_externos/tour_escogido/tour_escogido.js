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

let index = 0;

function moveCarousel(i) {
    if (!track || images.length === 0) return;
    index = (i + images.length) % images.length;
    track.style.transform = `translateX(-${index * 100}%)`;
    items.forEach(b => b.classList.remove("active"));
    if (items[index]) items[index].classList.add("active");
}

if (next) next.addEventListener("click", () => moveCarousel(index + 1));
if (prev) prev.addEventListener("click", () => moveCarousel(index - 1));

items.forEach((btn, i) => {
    btn.addEventListener("click", () => moveCarousel(i));
});

