<!-- Full Screen Map with Drawing Tools on Left + Exit Button + Info -->
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
    .leaflet-control-exit {
        background-color: white;
        border-radius: 4px;
        cursor: pointer;
        padding: 6px;
    }
    .leaflet-control-exit:hover {
        background-color: #f4f4f4;
    }
    /* Floating status window */
    #statusBox {
        position: absolute;
        bottom: 10px; /* Instead of top */
        right: 10px;
        background: rgba(255,255,255,0.9);
        padding: 10px;
        font-size: 14px;
        border-radius: 6px;
        box-shadow: 0px 2px 6px rgba(0,0,0,0.3);
        z-index: 1000;
    }
    
</style>

<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" /> -->
<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" /> -->

<div class="container-fluid" id="container-wrapper">
    <div id="pageMap"></div>
    <div id="statusBox">
        <b>Status:</b><br>
        Markers: 0<br>
        Circles: 0<br>
        Lines: 0<br>
        Polygons: 0<br>
        Rectangles: 0
    </div>
</div>

<!-- <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script> -->
<!-- <script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script> -->
<!-- <script src="https://unpkg.com/@turf/turf/turf.min.js"></script> -->

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

    // Shape layers
    var markerLayer = new L.FeatureGroup();
    var circleLayer = new L.FeatureGroup();
    var polylineLayer = new L.FeatureGroup();
    var polygonLayer = new L.FeatureGroup();
    var rectangleLayer = new L.FeatureGroup();

    // Layer control
    L.control.layers(
        { "OpenStreetMap": osm, "Satellite": satellite },
        { "Markers": markerLayer, "Circles": circleLayer, "Lines": polylineLayer, "Polygons": polygonLayer, "Rectangles": rectangleLayer }
    ).addTo(pageMap);

    // Add layers to map
    pageMap.addLayer(markerLayer);
    pageMap.addLayer(circleLayer);
    pageMap.addLayer(polylineLayer);
    pageMap.addLayer(polygonLayer);
    pageMap.addLayer(rectangleLayer);

    L.control.scale().addTo(pageMap);

    // Drawing Tools
    var drawControl = new L.Control.Draw({
        position: 'topleft',
        draw: {
            polyline: true,
            polygon: true,
            rectangle: true,
            circle: true,
            marker: true,
            circlemarker: false
        },
        edit: {
            featureGroup: L.featureGroup([markerLayer, circleLayer, polylineLayer, polygonLayer, rectangleLayer]),
            remove: true
        }
    });
    pageMap.addControl(drawControl);

    // Exit Button
    var exitControl = L.Control.extend({
        options: { position: 'topleft' },
        onAdd: function (map) {
            var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-exit');
            container.title = "Exit Map";
            container.innerHTML = "&#10006;";
            L.DomEvent.on(container, 'click', function () {
                window.location.href = "<?= base_url('dashboard') ?>";
            });
            return container;
        }
    });
    pageMap.addControl(new exitControl());

    // Update status box
    function updateStatus() {
        document.getElementById('statusBox').innerHTML =
            `<b>Status:</b><br>
            Markers: ${markerLayer.getLayers().length}<br>
            Circles: ${circleLayer.getLayers().length}<br>
            Lines: ${polylineLayer.getLayers().length}<br>
            Polygons: ${polygonLayer.getLayers().length}<br>
            Rectangles: ${rectangleLayer.getLayers().length}`;
    }

    // Handle Draw Events
    pageMap.on(L.Draw.Event.CREATED, function (event) {
        var layer = event.layer;
        var type = event.layerType;

        if (type === 'marker') {
            var latlng = layer.getLatLng();
            layer.bindPopup(`Marker<br>Lat: ${latlng.lat.toFixed(5)}<br>Lng: ${latlng.lng.toFixed(5)}`);
            markerLayer.addLayer(layer);
        }
        else if (type === 'circle') {
            var center = layer.getLatLng();
            var radius = layer.getRadius(); // meters
            var diameter = radius * 2;
            var area = Math.PI * radius * radius;
            var perimeter = 2 * Math.PI * radius;
            layer.bindPopup(
                `Circle<br>Center: ${center.lat.toFixed(5)}, ${center.lng.toFixed(5)}<br>` +
                `Radius: ${(radius/1000).toFixed(2)} km<br>` +
                `Diameter: ${(diameter/1000).toFixed(2)} km<br>` +
                `Area: ${(area/1000000).toFixed(2)} km²<br>` +
                `Perimeter: ${(perimeter/1000).toFixed(2)} km`
            );
            circleLayer.addLayer(layer);
        }
        else if (type === 'polyline') {
            var latlngs = layer.getLatLngs();
            var distance = 0;
            for (var i=0; i<latlngs.length-1; i++) {
                distance += pageMap.distance(latlngs[i], latlngs[i+1]);
            }
            layer.bindPopup(
                `Line<br>Start: ${latlngs[0].lat.toFixed(5)}, ${latlngs[0].lng.toFixed(5)}<br>` +
                `End: ${latlngs[latlngs.length-1].lat.toFixed(5)}, ${latlngs[latlngs.length-1].lng.toFixed(5)}<br>` +
                `Length: ${(distance/1000).toFixed(2)} km`
            );
            polylineLayer.addLayer(layer);
        }
        else if (type === 'polygon') {
            var coords = layer.getLatLngs()[0];
            var sides = coords.length;
            var turfPolygon = turf.polygon([[...coords.map(c => [c.lng, c.lat]), [coords[0].lng, coords[0].lat]]]);
            var area = turf.area(turfPolygon) / 1000000; // km²
            layer.bindPopup(
                `Polygon<br>Sides: ${sides}<br>` +
                `Area: ${area.toFixed(2)} km²`
            );
            polygonLayer.addLayer(layer);
        }
        else if (type === 'rectangle') {
            var bounds = layer.getBounds();
            var width = pageMap.distance(bounds.getNorthWest(), bounds.getNorthEast());
            var height = pageMap.distance(bounds.getNorthWest(), bounds.getSouthWest());
            var area = width * height / 1000000; // km²
            layer.bindPopup(
                `Rectangle<br>Width: ${(width/1000).toFixed(2)} km<br>` +
                `Height: ${(height/1000).toFixed(2)} km<br>` +
                `Area: ${area.toFixed(2)} km²`
            );
            rectangleLayer.addLayer(layer);
        }

        updateStatus();
    });

    // Handle Delete Events
    pageMap.on(L.Draw.Event.DELETED, function () {
        updateStatus();
    });
});
</script>
