<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        #map { height: 600px; }
    </style>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body>
    <div style="text-align: center">
        <h1>Informasi Gempa Terkini di Indonesia</h1>
        <h3>Sumber Data: BMKG</h3>
    </div>
    <div id="map"></div>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-0.3155398750904368, 117.1371634207888], 5);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 5,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Ambil data gempa dari BMKG menggunakan fetch
        fetch("https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json")
            .then(response => response.json())
            .then(data => {
                let gempas = data.Infogempa.gempa;
                let number = 1;

                // Iterasi data gempa dan tambahkan marker ke peta
                gempas.forEach(gempa => {
                    let koordinat = gempa.Coordinates.split(",");
                    let _lat = parseFloat(koordinat[0]);
                    let _long = parseFloat(koordinat[1]);

                    // Tambahkan marker ke peta
                    let marker = L.marker([_lat, _long]).addTo(map);
                    marker.bindPopup(
                        `<strong>${number}) Wilayah:</strong> ${gempa.Wilayah}<br>
                         <strong>Kedalaman:</strong> ${gempa.Kedalaman}<br>
                         <strong>Magnitudo:</strong> ${gempa.Magnitude} SR<br>
                         <strong>Potensi:</strong> ${gempa.Potensi}`
                    );
                    number++;
                });
            })
            .catch(error => {
                console.error("Gagal memuat data gempa:", error);
            });
    </script>
</body>
</html>
