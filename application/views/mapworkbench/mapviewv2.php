<?php

/**
 * ------------------------------------------------------------------------
 * Copyright (C) 2025 Lalulla OPC. All rights reserved.
 *
 * Copyright (c) 2017 - Jammi Dee (Joel M. Damaso) <jammi_dee@yahoo.com>
 * This file is part of the Lalulla System.
 *
 * Lalulla System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * ------------------------------------------------------------------------
 * PRODUCT NAME : CloudGate PHP Framework
 * AUTHOR       : Jammi Dee (Joel M. Damaso)
 * LOCATION     : Manila, Philippines
 * EMAIL        : jammi_dee@yahoo.com
 * CREATED DATE : August 13, 2025
 * ------------------------------------------------------------------------
 */

?>

<!-- Full Screen Map -->
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    #container-wrapper {
        padding: 0 !important; /* Remove Bootstrap container padding */
        margin: 0 !important;
    }
    #pageMap {
        height: calc(100vh); /* Adjust for header height if needed */
        width: 100%;
    }
</style>

<div class="container-fluid" id="container-wrapper">
    <div id="pageMap"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize Leaflet map
        var pageMap = L.map('pageMap').setView([14.822989, 120.2919185], 20);

        // Base layers
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(pageMap);

        var satellite = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', 
            { attribution: 'Tiles © Esri' }
        );

        // Marker Layer
        var markersLayer = L.layerGroup();
        L.marker([14.8231622, 120.2894002])
            .bindPopup("<strong>Sample Location</strong><br>Manila City, PH")
            .addTo(markersLayer);
        markersLayer.addTo(pageMap);

        // Layer control
        L.control.layers(
            { "OpenStreetMap": osm, "Satellite": satellite }, 
            { "Markers": markersLayer }
        ).addTo(pageMap);

        // Scale control
        L.control.scale().addTo(pageMap);
    });
</script>
