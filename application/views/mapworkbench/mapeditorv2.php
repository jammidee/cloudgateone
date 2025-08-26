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
  .popup-wrap { font-family: Arial, sans-serif; line-height: 1.4; min-width: 220px; }
  .popup-title { font-weight: 700; font-size: 14px; color: #2c3e50; margin-bottom: 6px; display:flex; gap:6px; align-items:center; }
  .popup-row { margin: 4px 0; }
  .popup-input { width: 100%; box-sizing: border-box; margin-top: 4px; }
  .apply-style { margin-top: 6px; padding: 6px 10px; cursor: pointer; }
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

<!-- libs -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  // Create map and set default view (OSM is default)
  var pageMap = L.map('pageMap').setView([14.5995, 120.9842], 13);

  // --- Base Layers ---
  var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
  }).addTo(pageMap); // OSM default

  var satellite = L.tileLayer(
    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
    { attribution: 'Tiles © Esri' }
  );

  // --- Per-type FeatureGroups (toggleable) ---
  var markerLayer     = new L.FeatureGroup();
  var circleLayer     = new L.FeatureGroup();
  var polylineLayer   = new L.FeatureGroup();
  var polygonLayer    = new L.FeatureGroup();
  var rectangleLayer  = new L.FeatureGroup();

  // Add groups to map so they are visible by default
  pageMap.addLayer(markerLayer);
  pageMap.addLayer(circleLayer);
  pageMap.addLayer(polylineLayer);
  pageMap.addLayer(polygonLayer);
  pageMap.addLayer(rectangleLayer);

  // --- Master group used by the edit/remove toolbar (must include everything editable) ---
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

  // --- Drawing Tools (edit references allDrawn) ---
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
      featureGroup: allDrawn,
      remove: true
    }
  });
  pageMap.addControl(drawControl);

  // --- Exit Button control ---
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

  // --- Save control ---
  var SaveControl = L.Control.extend({
    options: { position: 'topleft' },
    onAdd: function () {
      var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-exit');
      container.title = "Save Map";
      container.innerHTML = "💾";
      container.style.padding = "6px";
      container.style.cursor = "pointer";
      L.DomEvent.on(container, 'click', function () {
        saveMap();
      });
      return container;
    }
  });
  pageMap.addControl(new SaveControl());

  // --- Load control ---
  var LoadControl = L.Control.extend({
    options: { position: 'topleft' },
    onAdd: function () {
      var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-exit');
      container.title = "Load Map";
      container.innerHTML = "📂";
      container.style.padding = "6px";
      container.style.cursor = "pointer";
      L.DomEvent.on(container, 'click', function () {
        loadMap();
      });
      return container;
    }
  });
  pageMap.addControl(new LoadControl());

  // ======================== Utilities & helpers ========================
  function defaultColor(){ return "#3388ff"; }
  function defaultWeight(){ return 3; }

  // small colored marker icon (so markers can reflect chosen color & border)
  function makeMarkerIcon(color, weight){
    const size = 18;
    return L.divIcon({
      className: "custom-dot-icon",
      html: `<div style="
        width:${size}px;height:${size}px;border-radius:50%;
        background:${color};
        border:${Math.max(1, +weight || 2)}px solid #000;
      "></div>`,
      iconSize: [size, size],
      iconAnchor: [size/2, size/2]
    });
  }

  // apply style to a layer (and persist in layer.options)
  function setLayerStyle(layer, type, color, weight){
    layer.options.color  = color;
    layer.options.weight = parseInt(weight, 10) || defaultWeight();

    if (type === "marker") {
      layer.setIcon(makeMarkerIcon(color, layer.options.weight));
    } else if (layer.setStyle) {
      const style = { color: color, weight: layer.options.weight };
      if (type === "circle" || type === "polygon" || type === "rectangle") {
        style.fillColor = color;
      }
      layer.setStyle(style);
    }
  }

  function escapeHTML(s){ return (s||"").replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }
  function escapeAttr(s){ return escapeHTML(String(s||"")); }

  // --- update status box (counts per type) ---
  function updateStatus() {
    document.getElementById('statusBox').innerHTML =
      `<b>Status:</b><br>
       Markers: ${markerLayer.getLayers().length}<br>
       Circles: ${circleLayer.getLayers().length}<br>
       Lines: ${polylineLayer.getLayers().length}<br>
       Polygons: ${polygonLayer.getLayers().length}<br>
       Rectangles: ${rectangleLayer.getLayers().length}`;
  }

  // --- helper to compute rows shown in popup (keeps original data logic) ---
  function computeRows(layer, type){
    if (type === 'marker') {
      const pos = layer.getLatLng();
      return [
        { label: "Lat", value: pos.lat.toFixed(5) },
        { label: "Lng", value: pos.lng.toFixed(5) }
      ];
    }
    if (type === 'circle') {
      const center = layer.getLatLng();
      const radius = layer.getRadius(); // meters
      const diameter = radius * 2;
      const area = Math.PI * radius * radius;
      const perimeter = 2 * Math.PI * radius;
      return [
        { label: "Center", value: `${center.lat.toFixed(5)}, ${center.lng.toFixed(5)}` },
        { label: "Radius", value: `${(radius/1000).toFixed(2)} km` },
        { label: "Diameter", value: `${(diameter/1000).toFixed(2)} km` },
        { label: "Area", value: `${(area/1e6).toFixed(2)} km²` },
        { label: "Perimeter", value: `${(perimeter/1000).toFixed(2)} km` }
      ];
    }
    if (type === 'polyline') {
      const latlngs = layer.getLatLngs();
      let distance = 0;
      for (let i = 0; i < latlngs.length - 1; i++) {
        distance += pageMap.distance(latlngs[i], latlngs[i + 1]);
      }
      return [
        { label: "Start", value: `${latlngs[0].lat.toFixed(5)}, ${latlngs[0].lng.toFixed(5)}` },
        { label: "End", value: `${latlngs[latlngs.length - 1].lat.toFixed(5)}, ${latlngs[latlngs.length - 1].lng.toFixed(5)}` },
        { label: "Length", value: `${(distance/1000).toFixed(2)} km` }
      ];
    }
    if (type === 'polygon') {
      const coords = layer.getLatLngs()[0]; // first ring
      const sides = coords.length;
      const ring = coords.map(c => [c.lng, c.lat]);
      const poly = turf.polygon([[...ring, ring[0]]]); // close ring
      const areaKm2 = turf.area(poly) / 1e6;
      return [
        { label: "Sides", value: sides },
        { label: "Area", value: `${areaKm2.toFixed(2)} km²` }
      ];
    }
    if (type === 'rectangle') {
      const b = layer.getBounds();
      const width = pageMap.distance(b.getNorthWest(), b.getNorthEast());     // meters
      const height = pageMap.distance(b.getNorthWest(), b.getSouthWest());    // meters
      const areaKm2 = (width * height) / 1e6;
      return [
        { label: "Width", value: `${(width/1000).toFixed(2)} km` },
        { label: "Height", value: `${(height/1000).toFixed(2)} km` },
        { label: "Area", value: `${areaKm2.toFixed(2)} km²` }
      ];
    }
    return [];
  }

  function iconFor(type){
    return type === 'marker'    ? "📍" :
           type === 'circle'    ? "⭕" :
           type === 'polyline'  ? "📏" :
           type === 'polygon'   ? "🔺" :
           type === 'rectangle' ? "▭"  : "";
  }

  // --- Popup HTML generator (includes Tag + Color + Width controls) ---
  function popupHTML(title, icon, rows, layer) {
    const body = rows.map(r => `<div class="popup-row"><b>${r.label}:</b> ${r.value}</div>`).join("");
    const tag    = layer.options?.customTag || "";
    const color  = layer.options?.color || defaultColor();
    const weight = layer.options?.weight || defaultWeight();
    const tagHint = tag ? ` <span style="font-weight:400;color:#555;">— Tag: ${escapeHTML(tag)}</span>` : "";

    return `
      <div class="popup-wrap">
        <div class="popup-title">${icon} ${title}${tagHint}</div>
        ${body}
        <div class="popup-row">
          <label><b>Tag:</b></label>
          <input type="text" class="popup-input tag-input" value="${escapeAttr(tag)}">
        </div>
        <div class="popup-row">
          <label><b>Color:</b></label>
          <input type="color" class="popup-input color-input" value="${escapeAttr(color)}">
        </div>
        <div class="popup-row">
          <label><b>Line Width:</b></label>
          <input type="number" class="popup-input width-input" value="${escapeAttr(weight)}" min="1" max="20">
        </div>
        <button type="button" class="apply-style">Apply</button>
      </div>
    `;
  }

  // --- Resolve which type the layer belongs to (helper) ---
  function getTypeByMembership(layer){
    return  markerLayer.hasLayer(layer)     ? 'marker'    :
            circleLayer.hasLayer(layer)     ? 'circle'    :
            polylineLayer.hasLayer(layer)   ? 'polyline'  :
            polygonLayer.hasLayer(layer)    ? 'polygon'   :
            rectangleLayer.hasLayer(layer)  ? 'rectangle' : null;
  }

  // --- Bind / refresh popup content for a layer (keeps original popup behavior) ---
  function setPopup(layer, type) {
    const rows = computeRows(layer, type);
    const icon = iconFor(type);
    const title = type.charAt(0).toUpperCase()+type.slice(1);

    // If popup already exists, update content; otherwise bind a new popup
    if (layer.getPopup()) {
      layer.getPopup().setContent(popupHTML(title, icon, rows, layer));
    } else {
      layer.bindPopup(popupHTML(title, icon, rows, layer));
    }

    // Stamp some attributes on popup DOM when it opens so handlers/identity are easier
    layer.off('popupopen.__stamp').on('popupopen.__stamp', function(e){
      const el = e.popup && e.popup.getElement && e.popup.getElement();
      if (el) {
        el.setAttribute('data-layer-id', layer._leaflet_id);
        el.setAttribute('data-layer-type', type);
        // prevent map from swallowing clicks inside popup
        L.DomEvent.disableClickPropagation(el);
      }
    });

    // After geometry edit we re-generate the popup content (so displayed metrics stay current)
    layer.off('edit.__popup').on('edit.__popup', function () { setPopup(layer, type); updateStatus(); });
  }

  // --- add to all groups (master + type group) ---
  function addToGroups(layer, type) {
    allDrawn.addLayer(layer);
    if (type === 'marker') markerLayer.addLayer(layer);
    else if (type === 'circle') circleLayer.addLayer(layer);
    else if (type === 'polyline') polylineLayer.addLayer(layer);
    else if (type === 'polygon') polygonLayer.addLayer(layer);
    else if (type === 'rectangle') rectangleLayer.addLayer(layer);
  }

  // --- remove from type groups (used when deleting) ---
  function removeFromTypeGroups(layer) {
    if (markerLayer.hasLayer(layer)) markerLayer.removeLayer(layer);
    if (circleLayer.hasLayer(layer)) circleLayer.removeLayer(layer);
    if (polylineLayer.hasLayer(layer)) polylineLayer.removeLayer(layer);
    if (polygonLayer.hasLayer(layer)) polygonLayer.removeLayer(layer);
    if (rectangleLayer.hasLayer(layer)) rectangleLayer.removeLayer(layer);
  }

  // ================= Event: Create / Edit / Delete =================

  // When a shape is created with the draw toolbar
  pageMap.on(L.Draw.Event.CREATED, function (e) {
    var layer = e.layer;
    var type  = e.layerType;

    // For marker: use a draggable marker instance (keeps original behavior)
    if (type === 'marker') {
      const latlng = layer.getLatLng();
      layer = L.marker(latlng, { draggable: true });
      // set default icon/style so marker shows color/width when changed
      layer.options.color  = defaultColor();
      layer.options.weight = defaultWeight();
      layer.setIcon(makeMarkerIcon(layer.options.color, layer.options.weight));
      layer.on('dragend', function () { setPopup(layer, 'marker'); updateStatus(); });
    }

    // initialize style options for non-markers as well
    layer.options.color  = layer.options.color  || defaultColor();
    layer.options.weight = layer.options.weight || defaultWeight();

    // bind popup and add to groups
    setPopup(layer, type);
    addToGroups(layer, type);

    updateStatus();
  });

  // When shapes are edited via the toolbar (bulk)
  pageMap.on(L.Draw.Event.EDITED, function (e) {
    e.layers.eachLayer(function (layer) {
      const type = getTypeByMembership(layer);
      if (type) setPopup(layer, type);
    });
    updateStatus();
  });

  // When shapes are deleted via the toolbar
  pageMap.on(L.Draw.Event.DELETED, function (e) {
    e.layers.eachLayer(function (layer) {
      removeFromTypeGroups(layer);
      allDrawn.removeLayer(layer); // usually already removed
    });
    updateStatus();
  });

  // ================= APPLY Handling: attach handler on popupopen =================
  // This is the robust approach: attach the click handler to the current popup DOM each time it opens.
  // That way, we never rely on old DOM nodes (Leaflet replaces content sometimes).

  // Here we listen to the map's popupopen event at the map level to attach the Apply handlers.
  pageMap.on('popupopen', function(e){
    const popup = e.popup;
    const popupEl = popup.getElement();
    if (!popupEl) return;

    // prevent the map from swallowing clicks inside the popup
    L.DomEvent.disableClickPropagation(popupEl);

    // find control elements inside that popup DOM
    const applyBtn   = popupEl.querySelector('.apply-style');
    const tagInput   = popupEl.querySelector('.tag-input');
    const colorInput = popupEl.querySelector('.color-input');
    const widthInput = popupEl.querySelector('.width-input');

    // if no apply button, nothing to attach
    if (!applyBtn) return;

    // Avoid attaching many times: use a data attribute marker on the button DOM node
    if (applyBtn.dataset.handlerAttached) return;
    applyBtn.dataset.handlerAttached = '1';

    // Attach click handler to this button (works because popupEl is the current DOM)
    applyBtn.addEventListener('click', function(ev){
      L.DomEvent.stop(ev); // stop click from bubbling to map

      // read inputs (fallback to defaults)
      const tagVal   = tagInput ? tagInput.value : "";
      const colorVal = colorInput ? colorInput.value || defaultColor() : defaultColor();
      const widthVal = widthInput ? (parseInt(widthInput.value,10) || defaultWeight()) : defaultWeight();

      // We need to know which layer this popup belongs to.
      // The popup has a reference to its source layer under popup._source (Leaflet internals).
      const srcLayer = popup._source || null;
      if (!srcLayer) return;

      // Determine type of the source layer and persist tag
      const type = getTypeByMembership(srcLayer) || (srcLayer instanceof L.Marker ? 'marker' : null);

      // persist the tag and apply style
      srcLayer.options.customTag = tagVal;
      setLayerStyle(srcLayer, type, colorVal, widthVal);

      // Update popup title area in-place instead of re-binding content (avoids DOM replacement)
      const titleEl = popupEl.querySelector('.popup-title');
      if (titleEl) {
        // Rebuild the title HTML with tag hint included
        const icon = iconFor(type);
        const titleText = (type ? type.charAt(0).toUpperCase() + type.slice(1) : "Object");
        const tagHint = tagVal ? ` <span style="font-weight:400;color:#555;">— Tag: ${escapeHTML(tagVal)}</span>` : "";
        titleEl.innerHTML = `${icon} ${titleText}${tagHint}`;
      }

      // Also refresh numeric rows if needed (we won't replace inputs; only rows)
      const rows = computeRows(srcLayer, type);
      const bodyRowsHtml = rows.map(r => `<div class="popup-row"><b>${r.label}:</b> ${r.value}</div>`).join("");
      // Replace the first portion of the popup body (before tag/color controls)
      // find the first popup-row group and replace the block of existing metric rows.
      // For simplicity, replace the innerHTML of the popup except for the controls block by rebuilding:
      const controlsHtml = `
        <div class="popup-row">
          <label><b>Tag:</b></label>
          <input type="text" class="popup-input tag-input" value="${escapeAttr(tagVal)}">
        </div>
        <div class="popup-row">
          <label><b>Color:</b></label>
          <input type="color" class="popup-input color-input" value="${escapeAttr(colorVal)}">
        </div>
        <div class="popup-row">
          <label><b>Line Width:</b></label>
          <input type="number" class="popup-input width-input" value="${escapeAttr(widthVal)}" min="1" max="20">
        </div>
        <button type="button" class="apply-style">Apply</button>
      `;
      // replace entire popup content to keep layout consistent, but we will immediately re-attach handler
      // (we do this only to refresh rows; because we will re-attach the handler on the next popupopen event
      //  and we also call popup.update() below to reflect changes)
      const newContent = `
        <div class="popup-wrap">
          <div class="popup-title">${iconFor(type)} ${type ? type.charAt(0).toUpperCase() + type.slice(1) : 'Object'}${tagVal ? ` <span style="font-weight:400;color:#555;">— Tag: ${escapeHTML(tagVal)}</span>` : ""}</div>
          ${bodyRowsHtml}
          ${controlsHtml}
        </div>
      `;
      popup.setContent(newContent);
      popup.update();

      // After setContent replaced the DOM, Leaflet does not fire popupopen again,
      // so we need to manually re-attach the handler to the newly created button.
      setTimeout(function(){
        const newPopupEl = popup.getElement();
        if (!newPopupEl) return;
        // re-stamp data-layer-id/type for future use if needed
        newPopupEl.setAttribute('data-layer-id', srcLayer._leaflet_id);
        newPopupEl.setAttribute('data-layer-type', type);
        L.DomEvent.disableClickPropagation(newPopupEl);

        // find fresh apply button
        const freshBtn = newPopupEl.querySelector('.apply-style');
        if (freshBtn) {
          // avoid multiple bindings on the fresh button
          if (!freshBtn.dataset.handlerAttached) {
            freshBtn.dataset.handlerAttached = '1';
            freshBtn.addEventListener('click', function(ev2){
              // to be safe, call same handler logic (delegate to same code path)
              L.DomEvent.stop(ev2);
              // read inputs
              const tagVal2   = newPopupEl.querySelector('.tag-input')?.value || "";
              const colorVal2 = newPopupEl.querySelector('.color-input')?.value || defaultColor();
              const widthVal2 = parseInt(newPopupEl.querySelector('.width-input')?.value,10) || defaultWeight();
              // persist & style
              srcLayer.options.customTag = tagVal2;
              setLayerStyle(srcLayer, type, colorVal2, widthVal2);
              // refresh popup (replace content again)
              const rows2 = computeRows(srcLayer, type);
              popup.setContent(popupHTML(type.charAt(0).toUpperCase()+type.slice(1), iconFor(type), rows2, srcLayer));
              popup.update();
            });
          }
        }
      }, 0);

    }, { once: false }); // attach normally (we guard via dataset)
  });

  // ================= Save / Load (persist tag/color/weight & circle radius) =================

  function exportAllDrawn(){
    const features = [];
    allDrawn.eachLayer(function(layer){
      const type = getTypeByMembership(layer);
      if (!type) return;

      let gj;

      if (type === "circle") {
        // represent circle as Point + radius in properties
        const c = layer.getLatLng();
        gj = {
          type: "Feature",
          geometry: { type: "Point", coordinates: [c.lng, c.lat] },
          properties: { radius: layer.getRadius() }
        };
      } else {
        // use Leaflet's GeoJSON for others
        gj = layer.toGeoJSON();
        gj.properties = gj.properties || {};
        if (type === "rectangle") {
          gj.properties.rectangle = true; // flag so we know it was a rectangle
        }
      }

      // persist style + tag
      gj.properties = gj.properties || {};
      gj.properties._type = type; // explicit type
      gj.properties.tag   = layer.options.customTag || "";
      gj.properties.color = layer.options.color || defaultColor();
      gj.properties.weight= layer.options.weight || defaultWeight();

      features.push(gj);
    });

    return { type: "FeatureCollection", features };
  }

  function saveMap() {
    const fc = exportAllDrawn();
    const json = JSON.stringify(fc);
    const blob = new Blob([json], { type: "application/json" });
    const url = URL.createObjectURL(blob);

    const a = document.createElement("a");
    a.href = url;
    a.download = "map-data.json";
    a.click();
    URL.revokeObjectURL(url);
  }

  function loadMap() {
    const input = document.createElement("input");
    input.type = "file";
    input.accept = "application/json";

    input.onchange = (e) => {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = (event) => {
        const geojson = JSON.parse(event.target.result);
        const loaded = [];

        if (geojson && geojson.type === "FeatureCollection" && Array.isArray(geojson.features)) {
          geojson.features.forEach(function (f) {
            const props = f.properties || {};
            let type = props._type || (f.geometry && f.geometry.type ? f.geometry.type.toLowerCase() : null);

            // backward compatibility with original loader
            if (type === "point") type = props.radius ? "circle" : "marker";
            if (type === "linestring") type = "polyline";
            if (type === "polygon" && props.rectangle) type = "rectangle";
            else if (type === "polygon") type = "polygon";

            const color  = props.color || defaultColor();
            const weight = props.weight || defaultWeight();
            const tag    = props.tag || "";

            let layer;

            if (type === "circle") {
              const c = f.geometry.coordinates;
              const center = L.latLng(c[1], c[0]);
              layer = L.circle(center, {
                radius: props.radius || 100,
                color: color, weight: weight, fillColor: color
              });
              layer.options.customTag = tag;
            }
            else if (type === "marker") {
              const c = f.geometry.coordinates;
              const latlng = L.latLng(c[1], c[0]);
              layer = L.marker(latlng, { draggable: true });
              layer.options.customTag = tag;
              layer.options.color  = color;
              layer.options.weight = weight;
              layer.setIcon(makeMarkerIcon(color, weight));
              layer.on('dragend', function () { setPopup(layer, 'marker'); updateStatus(); });
            }
            else if (type === "polyline") {
              const pts = f.geometry.coordinates.map(([lng,lat]) => [lat,lng]);
              layer = L.polyline(pts, { color: color, weight: weight });
              layer.options.customTag = tag;
            }
            else if (type === "polygon" || type === "rectangle") {
              const ring = f.geometry.coordinates[0].map(([lng,lat]) => [lat,lng]);
              layer = L.polygon(ring, { color: color, weight: weight, fillColor: color });
              layer.options.customTag = tag;
            } else {
              return; // skip unknown
            }

            setPopup(layer, type);
            addToGroups(layer, type);
            loaded.push(layer);
          });
        }

        if (loaded.length) {
          const group = L.featureGroup(loaded);
          pageMap.fitBounds(group.getBounds(), { padding: [20,20] });
        }
        updateStatus();
      };
      reader.readAsText(file);
    };

    input.click();
  }

  // finally, update status at startup
  updateStatus();

});
</script>
