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

// Flechas
next.addEventListener("click", () => {
    index = (index + 1) % images.length;
    moveCarousel(index);
});

prev.addEventListener("click", () => {
    index = (index - 1 + images.length) % images.length;
    moveCarousel(index);
});

// Botones / miniaturas
items.forEach((btn, i) => {
    btn.addEventListener("click", () => {
        moveCarousel(i);
    });
});

// AUTOPLAY
function nextSlide() {
    index = (index + 1) % images.length;
    moveCarousel(index);
}

let autoPlayInterval = setInterval(nextSlide, 2000);

// Pausa al interactuar
carousel.addEventListener("mouseenter", () => {
    clearInterval(autoPlayInterval);
});

carousel.addEventListener("mouseleave", () => {
    autoPlayInterval = setInterval(nextSlide, 4000);
});



