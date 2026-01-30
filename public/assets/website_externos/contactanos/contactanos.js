// menu hamburguesa
const toggle = document.getElementById('menu-toggle');
const nav = document.getElementById('navbarNav');

toggle.addEventListener('click', () => {
    nav.classList.toggle('show');
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

