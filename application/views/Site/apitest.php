<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- API Test Page Content -->
<div class="container-login">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 p-5">
                            <div class="text-center mb-4">
                                <h1 class="h4 text-gray-900">API Test Page</h1>
                                <p class="text-muted">Test JWT-secured API endpoints</p>
                            </div>

                            <!-- API Test Form -->
                            <form id="apiTestForm">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" id="username" class="form-control" value="test">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" id="password" class="form-control" value="1234">
                                </div>
                                <button type="button" id="btnLogin" class="btn btn-primary btn-block">
                                    Get JWT Token
                                </button>
                            </form>

                            <hr>

                            <!-- Secure Data Test -->
                            <div class="form-group">
                                <label>JWT Token</label>
                                <textarea id="jwtToken" class="form-control" rows="3" readonly></textarea>
                            </div>
                            <button type="button" id="btnSecureData" class="btn btn-success btn-block">
                                Call Secure Data API
                            </button>

                            <hr>

                            <!-- Response Output -->
                            <div class="form-group">
                                <label>API Response</label>
                                <pre id="apiResponse" class="bg-light p-3 rounded" style="max-height:200px; overflow:auto;"></pre>
                            </div>

                            <div class="text-center mt-3">
                                <small class="text-muted">Powered by CodeIgniter 3 – API Tester</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- API Test Script -->
<script>
document.getElementById('btnLogin').addEventListener('click', function() {
    fetch('<?php echo base_url("jwtapi/login"); ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            username: document.getElementById('username').value,
            password: document.getElementById('password').value
        })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('jwtToken').value = data.token || '';
        document.getElementById('apiResponse').textContent = JSON.stringify(data, null, 2);
    });
});

document.getElementById('btnSecureData').addEventListener('click', function() {
    const token = document.getElementById('jwtToken').value;
    fetch('<?php echo base_url("jwtapi/secure_data"); ?>', {
        method: 'GET',
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('apiResponse').textContent = JSON.stringify(data, null, 2);
    });
});
</script>
<!-- End API Test Page Content -->
