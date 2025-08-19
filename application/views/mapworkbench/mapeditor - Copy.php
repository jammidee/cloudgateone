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
    bottom: 10px;      /* bottom so it doesn't cover the layers control */
    right: 10px;
    background: rgba(255,255,255,0.9);
    padding: 10px;
    font-size: 14px;
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    z-index: 1000;
  }
  /* Optional: a bit of style for popup headers */
  .popup-wrap { font-family: Arial, sans-serif; line-height: 1.4; min-width: 180px; }
  .popup-title { font-weight: 700; font-size: 14px; color: #2c3e50; margin-bottom: 6px; display:flex; gap:6px; align-items:center; }
  .popup-row { margin: 2px 0; }
</style>

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

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  var pageMap = L.map('pageMap').setView([14.5995, 120.9842], 13);

  // --- Base Layers ---
  var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
  }).addTo(pageMap);

  var satellite = L.tileLayer(
    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
    { attribution: 'Tiles © Esri' }
  );

  // --- Per-type shape layers (toggleable) ---
  var markerLayer     = new L.FeatureGroup();
  var circleLayer     = new L.FeatureGroup();
  var polylineLayer   = new L.FeatureGroup();
  var polygonLayer    = new L.FeatureGroup();
  var rectangleLayer  = new L.FeatureGroup();

  pageMap.addLayer(markerLayer);
  pageMap.addLayer(circleLayer);
  pageMap.addLayer(polylineLayer);
  pageMap.addLayer(polygonLayer);
  pageMap.addLayer(rectangleLayer);

  // --- Master group used by the edit/remove toolbar (CRITICAL for edit/delete) ---
  var allDrawn = new L.FeatureGroup().addTo(pageMap);

  // --- Layer control ---
  L.control.layers(
    { "OpenStreetMap": osm, "Satellite": satellite },
    {
      "Markers": markerLayer,
      "Circles": circleLayer,
      "Lines": polylineLayer,
      "Polygons": polygonLayer,
      "Rectangles": rectangleLayer
    }
  ).addTo(pageMap);

  L.control.scale().addTo(pageMap);

  // --- Drawing Tools (point to the master group) ---
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
      featureGroup: allDrawn,   // <-- key fix: edit/delete operates on this group
      remove: true
    }
  });
  pageMap.addControl(drawControl);

  // --- Exit Button (top-left, next to draw tools) ---
  var ExitControl = L.Control.extend({
    options: { position: 'topleft' },
    onAdd: function () {
      var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-exit');
      container.title = "Exit Map";
      container.innerHTML = "&#10006;";
      container.style.width = "32px";
      container.style.textAlign = "center";
      container.style.fontWeight = "bold";
      container.style.fontSize = "14px";
      L.DomEvent.on(container, 'click', function () {
        window.location.href = "<?= base_url('dashboard') ?>";
      });
      return container;
    }
  });
  pageMap.addControl(new ExitControl());

  // --- Status box updater ---
  function updateStatus() {
    document.getElementById('statusBox').innerHTML =
      `<b>Status:</b><br>
       Markers: ${markerLayer.getLayers().length}<br>
       Circles: ${circleLayer.getLayers().length}<br>
       Lines: ${polylineLayer.getLayers().length}<br>
       Polygons: ${polygonLayer.getLayers().length}<br>
       Rectangles: ${rectangleLayer.getLayers().length}`;
  }

  // --- Pretty popup builder ---
  function popupHTML(title, icon, rows) {
    const body = rows.map(r => `<div class="popup-row"><b>${r.label}:</b> ${r.value}</div>`).join("");
    return `
      <div class="popup-wrap">
        <div class="popup-title">${icon} ${title}</div>
        ${body}
      </div>
    `;
  }

  // --- Compute & set popup content for a layer by type ---
  function setPopup(layer, type) {
    if (type === 'marker') {
      const pos = layer.getLatLng();
      layer.bindPopup(popupHTML("Marker", "📍", [
        { label: "Lat", value: pos.lat.toFixed(5) },
        { label: "Lng", value: pos.lng.toFixed(5) }
      ]));
    }
    else if (type === 'circle') {
      const center = layer.getLatLng();
      const radius = layer.getRadius(); // meters
      const diameter = radius * 2;
      const area = Math.PI * radius * radius;
      const perimeter = 2 * Math.PI * radius;
      layer.bindPopup(popupHTML("Circle", "⭕", [
        { label: "Center", value: `${center.lat.toFixed(5)}, ${center.lng.toFixed(5)}` },
        { label: "Radius", value: `${(radius/1000).toFixed(2)} km` },
        { label: "Diameter", value: `${(diameter/1000).toFixed(2)} km` },
        { label: "Area", value: `${(area/1e6).toFixed(2)} km²` },
        { label: "Perimeter", value: `${(perimeter/1000).toFixed(2)} km` }
      ]));
    }
    else if (type === 'polyline') {
      const latlngs = layer.getLatLngs();
      let distance = 0;
      for (let i = 0; i < latlngs.length - 1; i++) {
        distance += pageMap.distance(latlngs[i], latlngs[i + 1]);
      }
      layer.bindPopup(popupHTML("Line", "📏", [
        { label: "Start", value: `${latlngs[0].lat.toFixed(5)}, ${latlngs[0].lng.toFixed(5)}` },
        { label: "End", value: `${latlngs[latlngs.length - 1].lat.toFixed(5)}, ${latlngs[latlngs.length - 1].lng.toFixed(5)}` },
        { label: "Length", value: `${(distance/1000).toFixed(2)} km` }
      ]));
    }
    else if (type === 'polygon') {
      const coords = layer.getLatLngs()[0]; // first ring
      const sides = coords.length;
      const ring = coords.map(c => [c.lng, c.lat]);
      const poly = turf.polygon([[...ring, ring[0]]]); // close ring
      const areaKm2 = turf.area(poly) / 1e6;
      layer.bindPopup(popupHTML("Polygon", "🔺", [
        { label: "Sides", value: sides },
        { label: "Area", value: `${areaKm2.toFixed(2)} km²` }
      ]));
    }
    else if (type === 'rectangle') {
      const b = layer.getBounds();
      const width = pageMap.distance(b.getNorthWest(), b.getNorthEast());     // meters
      const height = pageMap.distance(b.getNorthWest(), b.getSouthWest());    // meters
      const areaKm2 = (width * height) / 1e6;
      layer.bindPopup(popupHTML("Rectangle", "▭", [
        { label: "Width", value: `${(width/1000).toFixed(2)} km` },
        { label: "Height", value: `${(height/1000).toFixed(2)} km` },
        { label: "Area", value: `${areaKm2.toFixed(2)} km²` }
      ]));
    }
  }

  // --- Helper: add new layer to both its type group and the master group ---
  function addToGroups(layer, type) {
    allDrawn.addLayer(layer);
    if (type === 'marker') markerLayer.addLayer(layer);
    else if (type === 'circle') circleLayer.addLayer(layer);
    else if (type === 'polyline') polylineLayer.addLayer(layer);
    else if (type === 'polygon') polygonLayer.addLayer(layer);
    else if (type === 'rectangle') rectangleLayer.addLayer(layer);
  }

  // --- Helper: remove a layer from its type group if present (used on delete) ---
  function removeFromTypeGroups(layer) {
    if (markerLayer.hasLayer(layer)) markerLayer.removeLayer(layer);
    if (circleLayer.hasLayer(layer)) circleLayer.removeLayer(layer);
    if (polylineLayer.hasLayer(layer)) polylineLayer.removeLayer(layer);
    if (polygonLayer.hasLayer(layer)) polygonLayer.removeLayer(layer);
    if (rectangleLayer.hasLayer(layer)) rectangleLayer.removeLayer(layer);
  }

  // --- Draw CREATED ---
  pageMap.on(L.Draw.Event.CREATED, function (e) {
    var layer = e.layer;
    var type  = e.layerType;

    // Markers: replace with draggable instance
    if (type === 'marker') {
      const latlng = layer.getLatLng();
      layer = L.marker(latlng, { draggable: true });

      // keep popup in sync when user drags the marker
      layer.on('dragend', function () { setPopup(layer, 'marker'); updateStatus(); });
    }

    // set popup, add to groups
    setPopup(layer, type);
    addToGroups(layer, type);

    // ensure popup updates after geometry edits (vertex moves, reshape, etc.)
    layer.on('edit', function () { setPopup(layer, type); updateStatus(); });

    updateStatus();
  });

  // --- Draw EDITED (bulk edits via toolbar) ---
  pageMap.on(L.Draw.Event.EDITED, function (e) {
    e.layers.eachLayer(function (layer) {
      let type =
        markerLayer.hasLayer(layer)   ? 'marker'   :
        circleLayer.hasLayer(layer)   ? 'circle'   :
        polylineLayer.hasLayer(layer) ? 'polyline' :
        polygonLayer.hasLayer(layer)  ? 'polygon'  :
        rectangleLayer.hasLayer(layer)? 'rectangle': null;

      if (type) setPopup(layer, type);
    });
    updateStatus();
  });

  // --- Draw DELETED: also remove from the per-type groups to keep everything in sync ---
  pageMap.on(L.Draw.Event.DELETED, function (e) {
    e.layers.eachLayer(function (layer) {
      removeFromTypeGroups(layer);
      allDrawn.removeLayer(layer); // (usually already removed by the handler)
    });
    updateStatus();
  });
});
</script>
