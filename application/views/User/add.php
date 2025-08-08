<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= esc($title ?? '') ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/user/all">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container-fluid">
                <form action="<?= base_url('user/create'); ?>" method="post" enctype="multipart/form-data">

                    <!-- System Default -->
                    <input type="hidden" name="entityid" value="<?= $this->session->userdata('entityid') ?? '_NA_'; ?>">

                    <h5 class="mt-4"><b>Basic Information</b></h5>
                    <!-- Required Inputs -->
                    <div class="form-group">
                        <label><b>Name</b> <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name Here" required>
                    </div>
                    <div class="form-group">
                        <label><b>Mobile</b> <span class="text-danger">*</span></label>
                        <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile Number" required>
                    </div>
                    <div class="form-group">
                        <label><b>User ID</b> <span class="text-danger">*</span></label>
                        <input type="text" name="user_id" class="form-control" placeholder="Enter User ID" required>
                    </div>
                    <div class="form-group">
                        <label><b>Connection Pass</b> <span class="text-danger">*</span></label>
                        <input type="text" name="password" class="form-control" placeholder="Set user connection password" required>
                    </div>
                    <div class="form-group">
                        <label><b>Join Date</b> <span class="text-danger">*</span></label>
                        <input type="date" name="join_date" class="form-control" required>
                    </div>

                    <h5 class="mt-4"><b>Account Info</b></h5>
                    <!-- Optional Account Info -->
                    <div class="form-group">
                        <label><b>Email</b></label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label><b>Advance</b></label>
                        <input type="text" name="advance" class="form-control" placeholder="Advance payment">
                    </div>
                    <div class="form-group">
                        <label><b>Amount</b></label>
                        <input type="text" name="amount" class="form-control" placeholder="Billing Amount">
                    </div>
                    <div class="form-group">
                        <label><b>Account Password</b></label>
                        <input type="password" name="accpass" class="form-control" placeholder="Set login password">
                    </div>

                    <!-- Status and Role -->
                    <div class="form-group">
                        <label><b>Role</b> <span class="text-danger">*</span></label>
                        <select name="role" class="form-control" required>
                            <option value="">Select Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Manager">Manager</option>
                            <option value="Support">Support</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><b>Status</b> <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Pending">Pending</option>
                            <option value="Deactive">Deactive</option>
                            <option value="Warning">Warning</option>
                            <option value="Unpaid">Unpaid</option>
                            <option value="Paid">Paid</option>
                        </select>
                    </div>

                    <!-- Location & Remarks -->
                    <div class="form-group">
                        <label><b>Location</b></label>
                        <input type="text" name="location" class="form-control" placeholder="Enter Location">
                    </div>
                    <div class="form-group">
                        <label><b>Remarks</b></label>
                        <textarea name="remarks" class="form-control" placeholder="Enter Remarks"></textarea>
                    </div>

                    <!-- Tech Group Conditional Inputs -->
                    <?php if (canAccessMenu('user_update', $this->session->userdata('user_role'))): ?>
                        <h5 class="mt-4"><b>PETC Specific Information</b></h5>
                        <div class="form-group">
                            <label><b>Latitude</b></label>
                            <input type="text" name="lat" class="form-control" placeholder="Enter Latitude">
                        </div>
                        <div class="form-group">
                            <label><b>Longitude</b></label>
                            <input type="text" name="lon" class="form-control" placeholder="Enter Longitude">
                        </div>
                        <div class="form-group">
                            <label><b>PETC Code</b></label>
                            <select name="petc_code" class="form-control" required>
                                <option value="NA">Select PETC Code</option>
                                <?php foreach ($sites as $site): ?>
                                    <option value="<?= $site->PETC_CODE; ?>"><?= $site->PETC_CODE; ?> - <?= $site->PETC_NAME; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><b>Search Quota</b></label>
                            <input type="number" name="search_quota" class="form-control" value="100">
                        </div>
                        <div class="form-group">
                            <label><b>Start Time</b></label>
                            <input type="number" name="starttime" class="form-control" value="0" min="0" max="24">
                        </div>
                        <div class="form-group">
                            <label><b>End Time</b></label>
                            <input type="number" name="endtime" class="form-control" value="24" min="0" max="24">
                        </div>
                        <div class="form-group">
                            <label><b>Search Unlimited</b></label><br>
                            <input type="hidden" name="search_unli" value="0">
                            <input type="checkbox" name="search_unli" value="1" class="form-check-input">
                        </div>
                        <div class="form-group">
                            <label><b>Time Unlimited</b></label><br>
                            <input type="hidden" name="time_unli" value="0">
                            <input type="checkbox" name="time_unli" value="1" class="form-check-input">
                        </div>
                    <?php endif; ?>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">Create User</button>
                    <a href="<?= base_url('user/all'); ?>" class="btn btn-primary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!---Container Fluid--->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Customized scripts
    });
</script>
