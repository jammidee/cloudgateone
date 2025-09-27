<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/user/all">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <?php foreach ($edit_user as $row): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-fw fa-edit"></i> Edit User | <?= $row->name; ?>
                        </h6>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="<?= base_url(); ?>user/update" accept-charset="utf-8">
                            <input type="hidden" name="id" value="<?= $row->id; ?>">

                            <div class="form-group">
                                <label><b>Photo</b></label>
                                <input class="form-control" name="photo" type="file">
                            </div>

                            <div class="form-group">
                                <label><b>Name <span class="text-danger">*</span></b></label>
                                <input class="form-control" name="name" value="<?= $row->name; ?>" type="text" placeholder="Enter Name Here" required>
                            </div>

                            <div class="form-group">
                                <label><b>Mobile <span class="text-danger">*</span></b></label>
                                <input class="form-control" name="mobile" value="<?= $row->mobile; ?>" type="text" placeholder="Enter Mobile Number" required>
                            </div>

                            <?php if(notAdmin()): ?>
                                <!-- Package, Area, and Staff dropdowns are commented -->
                            <?php endif; ?>

                            <div class="form-group">
                                <label><b>User ID <span class="text-danger">*</span></b></label>
                                <input class="form-control" name="user_id" value="<?= $row->user_id; ?>" type="text" placeholder="Enter ID" required>
                            </div>

                            <div class="form-group">
                                <label><b>User Password <span class="text-danger">*</span></b></label>
                                <input class="form-control" name="password" value="<?= $row->password; ?>" type="text" placeholder="Leave blank to use old password" required>
                            </div>

                            <div class="form-group">
                                <label><b>Join Date <span class="text-danger">*</span></b></label>
                                <input class="form-control" name="join_date" value="<?= $row->join_date; ?>" type="date" required>
                            </div>

                            <div class="form-group">
                                <label><b>Role <span class="text-danger">*</span></b></label>
                                <select class="form-control" name="role" <?= ($row->role == "Admin") ? "disabled" : ""; ?> required>
                                    <option value="">Select Role</option>
                                    <option selected value="<?= $row->role; ?>"><?= $row->role; ?></option>
                                    <option value="Admin">Admin</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Support">Support</option>
                                    <option value="User">User</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label><b>Status <span class="text-danger">*</span></b></label>
                                <select class="form-control" name="status" required>
                                    <option value="">Select Status</option>
                                    <option selected value="<?= $row->status; ?>"><?= $row->status; ?></option>
                                    <option value="Active">Active</option>
                                    <option value="Deactive">Inactive</option>
                                    <option value="Warning">Warning</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Unpaid">Unpaid</option>
                                    <option value="Paid">Paid</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label><b>Account Password</b></label>
                                <input class="form-control" name="accpass" type="password" placeholder="Enter Password For Login">
                            </div>

                            <?php if(isTechGroup()): ?>
                                <div class="form-group">
                                    <label><b>Location</b></label>
                                    <input class="form-control" name="location" value="<?= $row->location; ?>" type="text" placeholder="Enter Location" required>
                                </div>

                                <div class="form-group">
                                    <label><b>Latitude</b></label>
                                    <input class="form-control" name="lat" value="<?= $row->lat; ?>" type="text" placeholder="Enter Latitude">
                                </div>

                                <div class="form-group">
                                    <label><b>Longitude</b></label>
                                    <input class="form-control" name="lon" value="<?= $row->lon; ?>" type="text" placeholder="Enter Longitude">
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label><b>Remarks</b></label>
                                <textarea class="form-control" name="remarks" placeholder="Enter Remarks"><?= $row->remarks; ?></textarea>
                            </div>

                            <?php if(isTechGroup()): ?>
                                <hr>
                                <h5 class="mb-3">PETC SPECIFIC INFORMATION</h5>

                                <div class="form-group">
                                    <label><b>PETC Code</b></label>
                                    <select class="form-control" name="petc_code" required>
                                        <option value="NA" <?= ($row->petc_code ?? 'NA') === 'NA' ? 'selected' : ''; ?>>Select PETC Code</option>
                                        <?php foreach ($sites as $site): ?>
                                            <option value="<?= $site->PETC_CODE; ?>" <?= ($row->petc_code ?? 'NA') === $site->PETC_CODE ? 'selected' : ''; ?>>
                                                (<?= $site->PETC_CODE; ?>) <?= $site->PETC_NAME; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><b>Search Quota</b></label>
                                    <input class="form-control" name="search_quota" value="<?= $row->search_quota ?? 100; ?>" type="number" placeholder="Enter Search Quota">
                                </div>

                                <div class="form-group">
                                    <label><b>Start Time</b></label>
                                    <input class="form-control" name="starttime" value="<?= $row->starttime ?? 0; ?>" type="number" min="0" max="24">
                                </div>

                                <div class="form-group">
                                    <label><b>End Time</b></label>
                                    <input class="form-control" name="endtime" value="<?= $row->endtime ?? 24; ?>" type="number" min="0" max="24">
                                </div>

                                <div class="form-group">
                                    <label><b>Search Unlimited</b></label><br>
                                    <input type="hidden" name="search_unli" value="0">
                                    <input class="form-check-input" name="search_unli" value="1" type="checkbox" <?= !empty($row->search_unli) ? 'checked' : ''; ?>>
                                </div>

                                <div class="form-group">
                                    <label><b>Time Unlimited</b></label><br>
                                    <input type="hidden" name="time_unli" value="0">
                                    <input class="form-check-input" name="time_unli" value="1" type="checkbox" <?= !empty($row->time_unli) ? 'checked' : ''; ?>>
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <button id="send" type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Now
                                </button>
                                <a href="<?= base_url('user/all'); ?>" class="btn btn-primary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!---Container Fluid--->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        //Put your customized page scripts
    });
</script>
