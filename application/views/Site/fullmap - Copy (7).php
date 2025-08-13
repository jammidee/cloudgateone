<!-- Full Screen Map with Built-in Leaflet Menu -->
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    #container-wrapper {
        padding: 0 !important;
        margin: 0 !important;
    }
    #pageMap {
        height: 100vh;
        width: 100%;
    }
    /* Style for custom Leaflet control */
    .leaflet-control.custom-menu {
        background: rgba(0, 0, 0, 0.7);
        padding: 6px;
        border-radius: 6px;
    }
    .leaflet-control.custom-menu a {
        display: block;
        color: white;
        text-decoration: none;
        background: #007bff;
        padding: 5px 8px;
        border-radius: 4px;
        font-size: 13px;
        margin-bottom: 4px;
        text-align: center;
        transition: background 0.3s;
    }
    .leaflet-control.custom-menu a:hover {
        background: #0056b3;
    }
</style>

<div class="container-fluid" id="container-wrapper">
    <div id="pageMap"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var pageMap = L.map('pageMap').setView([14.5995, 120.9842], 13);

        // Base Layers
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(pageMap);

        var satellite = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', 
            { attribution: 'Tiles © Esri' }
        );

        // Markers
        var markersLayer = L.layerGroup();
        L.marker([14.5995, 120.9842])
            .bindPopup("<strong>Sample Location</strong><br>Manila City, PH")
            .addTo(markersLayer);
        markersLayer.addTo(pageMap);

        // Layers Control
        L.control.layers(
            { "OpenStreetMap": osm, "Satellite": satellite }, 
            { "Markers": markersLayer }
        ).addTo(pageMap);

        L.control.scale().addTo(pageMap);

        // Custom Menu Control
        var MenuControl = L.Control.extend({
            options: { position: 'topright' }, // You can change to 'topleft', 'bottomleft', 'bottomright'
            onAdd: function (map) {
                var container = L.DomUtil.create('div', 'leaflet-control custom-menu');

                container.innerHTML = `
                    <a href="<?= base_url('mapworkbench/assets') ?>">Assets</a>
                    <a href="<?= base_url('mapworkbench/teams') ?>">Teams</a>
                    <a href="<?= base_url('mapworkbench/events') ?>">Events</a>
                    <a href="<?= base_url('dashboard') ?>">Dashboard</a>
                `;

                // Prevent clicks from interacting with the map
                L.DomEvent.disableClickPropagation(container);

                return container;
            }
        });

        pageMap.addControl(new MenuControl());
    });
</script>
