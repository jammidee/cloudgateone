<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">

    <!-- Embedded CSS -->
    <style>
        html {
            scroll-behavior: smooth;
        }
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 10px;
        }
        .service-card:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }
        .nav-link {
            color: white !important;
        }
        footer a.btn {
            color: white;
        }
        /* Leaflet Map Styles */
        #leafletMap {
            height: 500px;
            width: 100%;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
    </style>

    <!-- Map Section -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h3 class="text-center mt-4">Live Map</h3>
            <div id="leafletMap"></div>
        </div>
    </div>

</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Initialize map
    var map = L.map('leafletMap').setView([14.5995, 120.9842], 13); // Manila

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Example marker
    var marker = L.marker([14.5995, 120.9842])
        .addTo(map)
        .bindPopup("<strong>Sample Location</strong><br>Manila City, PH")
        .openPopup();
</script>
