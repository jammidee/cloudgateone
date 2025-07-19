<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Forgot Password Content -->
<div class="container-login">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 p-5">
                            <div class="text-center mb-4">
                                <h1 class="h4 text-gray-900">Forgot Your Password?</h1>
                                <p class="text-muted">Enter your email address and we'll send you a link to reset your password.</p>
                            </div>

                            <form class="user" method="post" action="<?= base_url('auth/send_reset_link'); ?>" accept-charset="utf-8">
                                <div class="form-group">
                                    <label>Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                </div>

                                <!-- Optional CAPTCHA Placeholder -->
                                <!-- <div class="form-group">
                                    <label>Captcha <span class="text-danger">*</span></label>
                                    <div><!= $captcha_html ?? '' ?></div>
                                </div> -->

                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-paper-plane"></i> Send Reset Link
                                </button>
                            </form>

                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('auth/login'); ?>">Back to Login</a>
                            </div>
                            <div class="text-center">
                                <a class="font-weight-bold small" href="<?= base_url('auth/register'); ?>">Create an Account!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>
<!-- End Forgot Password Content -->
