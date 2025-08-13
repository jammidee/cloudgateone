<!-- Full Screen Map with Menu -->
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
        height: calc(100vh - 50px); /* Leave space for menu bar */
        width: 100%;
    }
    .map-menu {
        height: 50px;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        display: flex;
        align-items: center;
        padding: 0 15px;
        gap: 10px;
        position: relative;
        z-index: 1000;
    }
    .map-menu a {
        color: white;
        text-decoration: none;
        background: #007bff;
        padding: 6px 12px;
        border-radius: 4px;
        transition: background 0.3s;
    }
    .map-menu a:hover {
        background: #0056b3;
    }
</style>

<div class="container-fluid" id="container-wrapper">
    
    <!-- Menu Bar -->
    <div class="map-menu">
        <a href="<?= base_url('mapworkbench/assets') ?>">Assets</a>
        <a href="<?= base_url('mapworkbench/teams') ?>">Teams</a>
        <a href="<?= base_url('mapworkbench/events') ?>">Events</a>
        <a href="<?= base_url('dashboard') ?>">Dashboard</a>
    </div>

    <!-- Map -->
    <div id="pageMap"></div>
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
