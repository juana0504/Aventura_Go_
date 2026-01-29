
let map;
let geocoder;
let marker;

function initMap() {
    geocoder = new google.maps.Geocoder();

    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 5.0139, lng: -74.4727 }, // Villeta
        zoom: 14
    });

    marker = new google.maps.Marker({
        map: map
    });
}

document.getElementById("formDireccion").addEventListener("submit", function (e) {
    e.preventDefault();

    const direccion = document.getElementById("direccion").value;

    geocoder.geocode({ address: direccion }, function (results, status) {
        if (status === "OK") {
            map.setCenter(results[0].geometry.location);
            marker.setPosition(results[0].geometry.location);
        } else {
            alert("No se pudo encontrar la dirección");
        }
    });
});

