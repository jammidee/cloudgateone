<!-- Full Screen Map with Floating Menu -->
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
    /* Floating menu inside map */
    .map-menu {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.7);
        padding: 8px;
        border-radius: 6px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .map-menu a {
        color: white;
        text-decoration: none;
        background: #007bff;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 14px;
        transition: background 0.3s;
        text-align: center;
    }
    .map-menu a:hover {
        background: #0056b3;
    }
</style>

<div class="container-fluid" id="container-wrapper">
    <div id="pageMap">
        <!-- Floating Menu -->
        <div class="map-menu">
            <a href="<?= base_url('mapworkbench/assets') ?>">Assets</a>
            <a href="<?= base_url('mapworkbench/teams') ?>">Teams</a>
            <a href="<?= base_url('mapworkbench/events') ?>">Events</a>
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var pageMap = L.map('pageMap').setView([14.5995, 120.9842], 13);

        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(pageMap);

        var satellite = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', 
            { attribution: 'Tiles © Esri' }
        );

        var markersLayer = L.layerGroup();
        L.marker([14.5995, 120.9842])
            .bindPopup("<strong>Sample Location</strong><br>Manila City, PH")
            .addTo(markersLayer);
        markersLayer.addTo(pageMap);

        L.control.layers(
            { "OpenStreetMap": osm, "Satellite": satellite }, 
            { "Markers": markersLayer }
        ).addTo(pageMap);

        L.control.scale().addTo(pageMap);
    });
</script>
