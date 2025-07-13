<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/user/all">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-fw fa-plus"></i> Add New User
                    </h6>
                </div>
                <div class="card-body">
                    <form class="form-horizontal form-label-left" role="form" enctype="multipart/form-data" method="post" action="<?= base_url(); ?>user/insert" accept-charset="utf-8">

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Photo</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="photo" type="file">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input class="form-control" id="name" name="name" type="text" placeholder="Enter Name Here" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Mobile <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input class="form-control" id="mobile" name="mobile" type="text" placeholder="Enter Mobile Number" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Connection ID <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input class="form-control" id="user_id" name="user_id" type="text" placeholder="Enter ID" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Connection Pass <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input class="form-control" id="password" name="password" type="text" placeholder="Set user connection password" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Join Date <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input class="form-control" id="join_date" name="join_date" type="date" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Role <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Support">Support</option>
                                    <option value="User">User</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Status <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Deactive">Inactive</option>
                                    <option value="Warning">Warning</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Unpaid">Unpaid</option>
                                    <option value="Paid">Paid</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Account Password</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="accpass" type="password" placeholder="Enter Password For Login">
                            </div>
                        </div>

                        <?php if (isTechGroup()): ?>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Location</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="location" type="text" placeholder="Enter Location">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Latitude</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="lat" type="text" placeholder="Enter Latitude">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Longitude</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="lon" type="text" placeholder="Enter Longitude">
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Remarks</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="remarks" placeholder="Enter Remarks"></textarea>
                            </div>
                        </div>

                        <?php if (isTechGroup()): ?>
                            <hr>
                            <h5 class="mb-3">PETC SPECIFIC INFORMATION</h5>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">PETC Code</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="petc_code" required>
                                        <option value="NA">Select PETC Code</option>
                                        <?php foreach ($sites as $site): ?>
                                            <option value="<?= $site->PETC_CODE; ?>"><?= $site->PETC_CODE; ?> - <?= $site->PETC_NAME; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Search Quota</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="search_quota" value="100" type="number" placeholder="Enter Search Quota">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Start Time</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="starttime" value="0" type="number" min="0" max="24">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">End Time</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="endtime" value="24" type="number" min="0" max="24">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Search Unlimited</label>
                                <div class="col-sm-6">
                                    <input type="hidden" name="search_unli" value="0">
                                    <input class="form-check-input" name="search_unli" value="1" type="checkbox">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Time Unlimited</label>
                                <div class="col-sm-6">
                                    <input type="hidden" name="time_unli" value="0">
                                    <input class="form-check-input" name="time_unli" value="1" type="checkbox">
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="form-group row">
                            <div class="col-sm-6 offset-sm-3">
                                <button id="send" type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Create User
                                </button>
                                <a href="<?= base_url('user/all'); ?>" class="btn btn-primary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        //Put your customized page scripts
    });
</script>
