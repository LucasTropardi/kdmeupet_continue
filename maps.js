var map = L.map('map').setView([-21.4209, -50.078], 13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

L.marker([-21.4194389, -50.0747436]).addTo(map)
    .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')


    L.marker([-21.4209, -50.078]).addTo(map)
    .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
