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

    <div class="col-lg-12">
        <div class="card mb-4 shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary mr-3 text-nowrap">
                        <i class="fas fa-fw fa-edit"></i> Edit User
                    </h6>
                </div>
            </div>
            <div class="card-body">
                <?php foreach ($edit_user as $row): ?>
                <!-- Edit User Form -->
                <form class="form-horizontal" role="form" enctype="multipart/form-data"
                      method="post" action="<?= base_url(); ?>user/update" accept-charset="utf-8">
                    <input type="hidden" name="id" value="<?= $row->id; ?>">

                    <div class="row">
                        <!-- Photo -->
                        <div class="col-md-12 mb-3">
                            <label><b>Photo</b></label>
                            <input class="form-control" name="photo" type="file">
                        </div>

                        <!-- Email, User Password, User Password -->
                        <div class="col-md-4 mb-3">
                            <label><b>Name <span class="text-danger">*</span></b></label>
                            <input class="form-control" name="name" value="<?= $row->name; ?>"
                                   type="text" placeholder="User name required" >
                        </div>
                        <div class="col-md-4 mb-3">
                            <label><b>Email <span class="text-danger">*</span></b></label>
                            <input class="form-control" name="email" value="<?= $row->email; ?>"
                                   type="text" placeholder="Email Address" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label><b>User Password <span class="text-danger">*</span></b></label>
                            <input class="form-control" name="password" value=""
                                   type="text" placeholder="Leave blank to use old password">
                        </div>
                        <!-- <div class="col-md-4 mb-3">
                            <label><b>User Password (Confirm)</b></label>
                            <input class="form-control" name="password_confirm"
                                   type="text" placeholder="Re-enter password">
                        </div> -->

                        <!-- Role, Join Date, Status -->
                        <div class="col-md-4 mb-3">
                            <label><b>Role <span class="text-danger">*</span></b></label>
                            <select class="form-control" name="role" <?= ($row->role == "Admin") ? "disabled" : ""; ?> required>
                                <option value="">Select Role</option>
                                <option selected value="<?= $row->role; ?>"><?= $row->role; ?></option>
                                <option value="Admin">Admin</option>
                                <option value="Manager">Manager</option>
                                <option value="Support">Support</option>
                                <option value="Reviewer">Reviewer</option>
                                <option value="Approver">Approver</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label><b>Join Date <span class="text-danger">*</span></b></label>
                            <input class="form-control" name="join_date" value="<?= $row->join_date; ?>"
                                   type="date" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label><b>Status <span class="text-danger">*</span></b></label>
                            <select class="form-control" name="status" required>
                                <option value="">Select Status</option>
                                <option value="Active"   <?= ($row->status == "Active") ? "selected" : ""; ?>>Active</option>
                                <option value="Inactive" <?= ($row->status == "Inactive") ? "selected" : ""; ?>>Inactive</option>
                            </select>
                        </div>

                        <?php if(isTechGroup()): ?>
                        <!-- Location, Latitude, Longitude -->
                        <div class="col-md-4 mb-3">
                            <label><b>Location</b></label>
                            <input class="form-control" name="location" value="<?= $row->location; ?>"
                                   type="text" placeholder="Please enter user location" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label><b>Latitude</b></label>
                            <input class="form-control" name="lat" value="<?= $row->lat; ?>"
                                   type="text" placeholder="Enter Latitude">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label><b>Longitude</b></label>
                            <input class="form-control" name="lon" value="<?= $row->lon; ?>"
                                   type="text" placeholder="Enter Longitude">
                        </div>
                        <?php endif; ?>

                        <!-- Remarks -->
                        <div class="col-md-12 mb-3">
                            <label><b>Remarks</b></label>
                            <textarea class="form-control" name="remarks" placeholder="Enter Remarks"><?= $row->remarks; ?></textarea>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="text-right">
                        <button id="send" type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Now
                        </button>
                        <a href="<?= base_url('user/all'); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!---Container Fluid--->

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Put your customized page scripts
});
</script>
