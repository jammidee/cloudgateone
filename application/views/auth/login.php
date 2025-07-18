<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Login Content -->
<div class="container-login">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 p-5">
                            <div class="text-center mb-4">
                                <h1 class="h4 text-gray-900">Welcome Back</h1>
                                <p class="text-muted">Please login to your <?= $this->config->item('appname'); ?> account</p>
                            </div>

                            <form class="user" method="post" action="<?php echo base_url('auth/checkinguser'); ?>" accept-charset="utf-8">
                                <div class="form-group">
                                    <label>Email Address <span class="text-danger">*</span></label>
                                    <!-- <input type="email" class="form-control" name="email" placeholder="Enter Email Address" required> -->
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?= isset($remember_email) ? $remember_email : '' ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <!-- <input type="password" class="form-control" name="password" placeholder="Password" required> -->
                                    <input type="password" name="password" class="form-control" placeholder="Password" value="<?= isset($remember_password) ? $remember_password : '' ?>" required>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="rememberMe" name="remember">
                                        <label class="custom-control-label" for="rememberMe">Remember Me</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-lock"></i> Login Now
                                </button>

                                <hr>

                                <!-- <a href="#" class="btn btn-google btn-block">
                                    <i class="fab fa-google fa-fw"></i> Login with Google
                                </a>
                                <a href="#" class="btn btn-facebook btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                </a> -->

                            </form>

                            <hr>
                            <div class="text-center">
                                <a class="font-weight-bold small" href="<?php echo base_url('register'); ?>">Create an Account!</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="<?php echo base_url('forgot-password'); ?>">Forgot Password?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>
<!-- End Login Content -->
