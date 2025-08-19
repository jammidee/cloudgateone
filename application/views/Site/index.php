<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Welcome Page Content -->
<div class="container-login">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 p-5">
                            <div class="text-center mb-4">
                                <h1 class="h4 text-gray-900">Welcome to CG Landing Page</h1>
                                <p class="text-muted">Site Landing Page</p>
                            </div>

                            <ul class="list-group list-group-flush mb-4 shadow-sm rounded">
                                <li class="list-group-item">🔐 Security-First Architecture</li>
                                <li class="list-group-item">👥 User & Role Management</li>
                                <li class="list-group-item">⚙️ Configurable Environment</li>
                                <li class="list-group-item">🚀 Ready for Rapid Development</li>
                            </ul>

                            <div class="text-center mt-4">
                                <a href="<?php echo base_url('auth/login'); ?>" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-sign-in-alt"></i> Get Started – Login
                                </a>
                            </div>

                            <div class="text-center mt-4">
                                <a href="<?php echo base_url('site/main'); ?>" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-sign-in-alt"></i> Visit Sidebar Main Page
                                </a>
                            </div>

                            <div class="text-center mt-4">
                                <a href="<?php echo base_url('site/flyer'); ?>" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-file-alt"></i> Visit Flyer With Sidebar Page
                                </a>
                            </div>

                            <div class="text-center mt-4">
                                <a href="<?php echo base_url('site/fullflyer'); ?>" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-file"></i> Visit Full Flyer Page
                                </a>
                            </div>

                            <div class="text-center mt-4">
                                <a href="<?php echo base_url('site/fullmap'); ?>" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-map-marked-alt"></i> Visit Full Map Page
                                </a>
                            </div>

                            <div class="text-center mt-4">
                                <a href="<?php echo base_url('site/fullcalendar'); ?>" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-map-marked-alt"></i> Visit Full Calendar Page
                                </a>
                            </div>

                            <div class="text-center mt-3">
                                <small class="text-muted">Need help? Check the documentation or contact support.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>
<!-- End Welcome Page Content -->
