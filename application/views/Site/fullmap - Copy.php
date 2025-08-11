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
    </style>

    <!-- Navigation -->
    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 rounded shadow-sm"> -->
        <!-- <div class="container"> -->

            <!-- Logo and Brand -->
            <!-- <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="<!= base_url('assets/img/logo/logo.png'); ?>" alt="Logo" style="height: 30px; margin-right: 10px;">
                <span>ACME</span>
            </a> -->

            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button> -->
            <!-- <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#who">Who We Are</a></li>
                    <li class="nav-item"><a class="nav-link" href="#mission">Mission/Vision</a></li>
                    <li class="nav-item"><a class="nav-link" href="#core-values">Core Values</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="<!= base_url('auth/login'); ?>" style="color:white;">
                            Login
                        </a>
                    </li>
                </ul>
            </div> -->

        <!-- </div> -->

    <!-- </nav> -->

    <!-- Header -->
    <!-- <div class="text-center mb-5">
        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1350&q=80"
             alt="Tech Banner" class="img-fluid rounded shadow-sm"
             style="max-height: 250px; width: 100%; object-fit: cover;">
        <h2 class="pt-4 text-primary">Empowering the Technical Industry</h2>
        <p class="lead">ACME Company provides curated resources and tools tailored for developers, engineers, and tech professionals.</p>
    </div> -->

    <!-- Who We Are -->
    <!-- <div id="who" class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
            <h3>Who We Are</h3>
            <p>ACME is a forward-thinking resource hub designed by and for technical professionals. We provide structured content, tooling guidance, and productivity assets to help you scale your technical growth.</p>
        </div>
    </div> -->

    <!-- Mission / Vision -->
    <!-- <div id="mission" class="row justify-content-center mb-5 bg-light p-4 rounded shadow-sm">
        <div class="col-lg-8 text-center">
            <h3>Our Mission & Vision</h3>
            <p><strong>Mission:</strong> To empower the global technical workforce with reliable, high-quality tools and learning resources.</p>
            <p><strong>Vision:</strong> To be the most trusted resource platform for developers and engineers worldwide.</p>
        </div>
    </div> -->

    <!-- Core Values -->
    <!-- <div id="core-values" class="row justify-content-center mb-5 bg-white p-4 rounded shadow-sm">
        <div class="col-lg-10 text-center">
            <h3 class="mb-4">Our Core Values</h3>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <img src="https://img.icons8.com/fluency/96/000000/light-on.png" alt="Innovation">
                    <h5 class="mt-2">Innovation</h5>
                    <p>We stay ahead by continuously evolving with modern tech trends and offering creative solutions.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <img src="https://img.icons8.com/fluency/96/000000/handshake.png" alt="Integrity">
                    <h5 class="mt-2">Integrity</h5>
                    <p>We believe in transparency, honesty, and long-lasting relationships with our partners and users.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <img src="https://img.icons8.com/fluency/96/000000/teamwork.png" alt="Collaboration">
                    <h5 class="mt-2">Collaboration</h5>
                    <p>We foster a culture of knowledge sharing, community contribution, and inclusive teamwork.</p>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Services -->
    <!-- <div id="services" class="row justify-content-center mb-5">
        <div class="col-lg-10 text-center">
            <h3>Our Services</h3>
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100 service-card">
                        <div class="card-body">
                            <h5 class="card-title">Developer Toolkits</h5>
                            <p class="card-text">Templates, boilerplates, and CLI tools to streamline workflows across languages.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100 service-card">
                        <div class="card-body">
                            <h5 class="card-title">API Integrations</h5>
                            <p class="card-text">Ready-to-use API blueprints and integration patterns for fintech and logistics.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100 service-card">
                        <div class="card-body">
                            <h5 class="card-title">Mentoring</h5>
                            <p class="card-text">One-on-one or team sessions, paired programming, and code reviews by experts.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100 service-card">
                        <div class="card-body">
                            <h5 class="card-title">DevOps Resources</h5>
                            <p class="card-text">Docker, Kubernetes, CI/CD pipelines, monitoring dashboards, and scaling tips.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100 service-card">
                        <div class="card-body">
                            <h5 class="card-title">Documentation</h5>
                            <p class="card-text">Deploy clean documentation with tools like Swagger, Docusaurus, and MkDocs.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100 service-card">
                        <div class="card-body">
                            <h5 class="card-title">Resource Curation</h5>
                            <p class="card-text">Cheat sheets, books, podcasts, newsletters, and community picks — all in one place.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Call to Action -->
    <!-- <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
            <img src="https://img.icons8.com/ios-filled/100/idea.png" alt="Idea Icon" style="max-height: 90px;">
            <h4 class="pt-3">Save your <b>imagination</b> on blank canvas!</h4>
            <p class="mt-3">From documentation templates to community-driven plugins — we equip you to build faster, better, and smarter.</p>
        </div>
    </div> -->

    <!-- Footer -->
    <!-- <div id="contact">
        <footer class="p-4 text-white" style="background-color: #000;">
            <div class="row text-center text-md-left">
                <div class="col-md-4 mb-4">
                    <h5>About Us</h5>
                    <p>ACME is a dedicated resource hub crafted by industry experts to help professionals thrive in the fast-paced world of technology.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li>Email: contact@acmeresources.com</li>
                        <li>Phone: +63 900 123 4567</li>
                        <li>Address: Makati City, Philippines</li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Follow Us</h5>
                    <a href="#" class="btn btn-sm m-1" style="background-color: #3b5998;">Facebook</a>
                    <a href="#" class="btn btn-sm m-1" style="background-color: #1da1f2;">Twitter</a>
                    <a href="#" class="btn btn-sm m-1" style="background-color: #333;">GitHub</a>
                </div>
            </div>
            <hr class="bg-white">
            <p class="text-center small mb-0">&copy; <!= date('Y'); ?> ACME Company. All Rights Reserved.</p>
        </footer>
    </div> -->

</div>
<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    
</script>
