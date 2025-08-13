<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Full Page Map with Controls</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #leafletMap {
            height: 100%;
            width: 100%;
        }
    </style>
</head>
<body>

<div id="leafletMap"></div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // Base Layers
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    });

    var satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles © Esri'
    });

    var topo = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
        maxZoom: 17,
        attribution: 'Map data © OpenStreetMap contributors, SRTM | Map style © OpenTopoMap'
    });

    // Map Init
    var map = L.map('leafletMap', {
        center: [14.5995, 120.9842],
        zoom: 13,
        layers: [osm] // default
    });

    // Overlay Layer Example
    var marker = L.marker([14.5995, 120.9842]).bindPopup("<strong>Sample Location</strong><br>Manila City, PH");
    var markersLayer = L.layerGroup([marker]);

    // Layer Control
    var baseMaps = {
        "OpenStreetMap": osm,
        "Satellite": satellite,
        "Topographic": topo
    };

    var overlayMaps = {
        "Markers": markersLayer
    };

    L.control.layers(baseMaps, overlayMaps).addTo(map);

    // Add markers overlay to map by default
    markersLayer.addTo(map);

    // Zoom Control (already in Leaflet, but can be repositioned)
    L.control.zoom({
        position: 'topright'
    }).addTo(map);

    // Scale Bar
    L.control.scale().addTo(map);
</script>
</body>
</html>
