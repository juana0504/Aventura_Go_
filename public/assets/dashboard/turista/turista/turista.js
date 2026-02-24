document.addEventListener("DOMContentLoaded", function () {
    const carousels = document.querySelectorAll('.carousel');
    carousels.forEach(function (carousel) {
        new bootstrap.Carousel(carousel, {
            interval: 5000,
            ride: 'carousel',
            keyboard: true  // Asegúrate de que 'keyboard' sea un valor válido.
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".flip-card");

    cards.forEach(card => {
        card.addEventListener("mouseenter", () => {
            card.classList.add("flip-active");
        });

        card.addEventListener("mouseleave", () => {
            card.classList.remove("flip-active");
        });
    });
});


// Gráfico de Actividades
const ctx = document.getElementById('actividadesChart').getContext('2d');
const actividadesChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Actividad 1', 'Actividad 2', 'Actividad 3'],  // Ajusta las etiquetas según tus actividades
        datasets: [{
            label: 'Número de Actividades',
            data: [5, 10, 3], // Ajusta los valores de tus actividades
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

document.addEventListener("DOMContentLoaded", function() {
   // Datos del gráfico
   const ctx = document.getElementById('actividadesChart').getContext('2d');
   const actividadesChart = new Chart(ctx, {
       type: 'bar',  // Tipo de gráfico (puede ser 'line', 'bar', 'pie', etc.)
       data: {
           labels: ['Paracaidismo', 'Bungee Jumping', 'Escalada en roca'],  // Etiquetas de las barras
           datasets: [{
               label: 'Actividades Programadas',
               data: [3, 5, 1],  // Valores de cada actividad (pueden ser visitas, número de actividades, etc.)
               backgroundColor: '#FFD700',  // Color de las barras
               borderColor: '#e74c3c',  // Color del borde de las barras
               borderWidth: 1
           }]
       },
       options: {
           scales: {
               y: {
                   beginAtZero: true  // Comienza el eje Y desde 0
               }
           }
       }
   });
});

// turista.js

document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById('actividadesChart').getContext('2d');
    const actividadesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Paracaidismo', 'Bungee Jumping', 'Escalada en roca'],  // Ajusta las etiquetas según tus actividades
            datasets: [{
                label: 'Número de Actividades',
                data: [3, 2, 1], // Ajusta los valores de tus actividades (pueden ser visitas, número de actividades, etc.)
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
