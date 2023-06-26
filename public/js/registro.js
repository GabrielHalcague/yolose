$(document).ready(function () {
    var map = L.map('map').setView([-34.667890, -58.565806 ], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var popup = L.popup();
    function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(map);

        var coordenadaString = e.latlng.toString();
        var numerosCoordenada = coordenadaString.match(/-?[\d\.]+/g);

        var inputNombre = document.getElementById("coordenadas");
        inputNombre.value = numerosCoordenada;
    }
    map.on('click', onMapClick);
});