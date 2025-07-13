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

    <!-- <div class="text-center mb-4">
        <img src="<1= base_url('assets/'); ?>img/think.svg" style="max-height: 90px">
        <h4 class="pt-3">Save your <b>imagination</b> On Blank Canvas!</h4>
    </div> -->

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <?php foreach ($edit_user as $row): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-fw fa-edit"></i> Edit User | <?= $row->name; ?>
                        </h6>
                        <!-- <div>
                            <a href="https://www.google.com/maps?q=<!= $row->lat; ?>,<!= $row->lon; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="material-icons">location_on</i> View on Map
                            </a>
                            <a href="<1= base_url('user/all'); ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="material-icons">arrow_back</i> Back
                            </a>
                        </div> -->
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal form-label-left" role="form" enctype="multipart/form-data" method="post" action="<?= base_url(); ?>user/update" accept-charset="utf-8">
                            <input id="id" name="id" value="<?= $row->id; ?>" type="hidden">

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Photo</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="photo" type="file">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Name <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="name" name="name" value="<?= $row->name; ?>" type="text" placeholder="Enter Name Here" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Mobile <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="mobile" name="mobile" value="<?= $row->mobile; ?>" type="text" placeholder="Enter Mobile Number" required>
                                </div>
                            </div>

                            <?php if(notAdmin()): ?>
                                <!-- <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Package <span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="package" name="package" required>
                                            <option value="">Select Package</option>
                                            <!php if(package($row->package)): ?>
                                                <option selected value="<!= package($row->package)->packid; ?>"><!= package($row->package)->packname; ?> (Current)</option>
                                            <!php endif; ?>
                                            <!php foreach ($packages as $pack): ?>
                                                <option value="<!= $pack->packid; ?>"><!= $pack->packname; ?> (<!= $pack->packvolume; ?>) (<!= $pack->packprice; ?>)<!= $pack->total ? " ({$pack->total})" : ''; ?></option>
                                            <!php endforeach; ?>
                                        </select>
                                    </div>
                                </div> -->

                                <!-- <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Area <span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="area" required>
                                            <option value="">Select Area</option>
                                            <option selected value="<!= $row->area; ?>"><!= $row->area; ?> (Current)</option>
                                            <!php foreach ($area as $a): ?>
                                                <option value="<!= $a->name; ?>"><!= $a->name; ?></option>
                                            <!php endforeach; ?>
                                        </select>
                                    </div>
                                </div> -->

                                <!-- <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Technical Support/Staff <span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="staff" required>
                                            <option value="">Select Line Man/Staff</option>
                                            <!php if(staffByID($row->staff)): ?>
                                                <option selected value="<!= $row->staff; ?>"><!= staffByID($row->staff)->name; ?> (Current)</option>
                                            <!php endif; ?>
                                            <!php foreach ($staff as $s): ?>
                                                <option value="<!= $s->id; ?>"><!= $s->name; ?></option>
                                            <!php endforeach; ?>
                                        </select>
                                    </div>
                                </div> -->
                            <?php endif; ?>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Connection ID <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="user_id" name="user_id" value="<?= $row->user_id; ?>" type="text" placeholder="Enter ID" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Connection Pass <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="password" name="password" value="<?= $row->password; ?>" type="text" placeholder="Leave blank to use old password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Join Date <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="join_date" name="join_date" value="<?= $row->join_date; ?>" type="date" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Role <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select <?= ($row->role == "Admin") ? "disabled" : ""; ?> class="form-control" name="role" required>
                                        <option value="">Select Role</option>
                                        <option selected value="<?= $row->role; ?>"><?= $row->role; ?></option>
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
                                        <option selected value="<?= $row->status; ?>"><?= $row->status; ?></option>
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

                            <?php if(isTechGroup()): ?>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Location</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="location" value="<?= $row->location; ?>" type="text" placeholder="Enter Location" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Latitude</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="lat" value="<?= $row->lat; ?>" type="text" placeholder="Enter Latitude">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Longitude</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="lon" value="<?= $row->lon; ?>" type="text" placeholder="Enter Longitude">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Remarks</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="remarks" placeholder="Enter Remarks"><?= $row->remarks; ?></textarea>
                                </div>
                            </div>

                            <?php if(isTechGroup()): ?>
                                <hr>
                                <h5 class="mb-3">PETC SPECIFIC INFORMATION</h5>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">PETC Code</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="petc_code" required>
                                            <option value="NA" <?= ($row->petc_code ?? 'NA') === 'NA' ? 'selected' : ''; ?>>Select PETC Code</option>
                                            <?php foreach ($sites as $site): ?>
                                                <option value="<?= $site->PETC_CODE; ?>" <?= ($row->petc_code ?? 'NA') === $site->PETC_CODE ? 'selected' : ''; ?>>
                                                    (<?= $site->PETC_CODE; ?>) <?= $site->PETC_NAME; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Search Quota</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="search_quota" value="<?= $row->search_quota ?? 100; ?>" type="number" placeholder="Enter Search Quota">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Start Time</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="starttime" value="<?= $row->starttime ?? 0; ?>" type="number" min="0" max="24">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">End Time</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="endtime" value="<?= $row->endtime ?? 24; ?>" type="number" min="0" max="24">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Search Unlimited</label>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="search_unli" value="0">
                                        <input class="form-check-input" name="search_unli" value="1" type="checkbox" <?= !empty($row->search_unli) ? 'checked' : ''; ?>>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Time Unlimited</label>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="time_unli" value="0">
                                        <input class="form-check-input" name="time_unli" value="1" type="checkbox" <?= !empty($row->time_unli) ? 'checked' : ''; ?>>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="form-group row">
                                <div class="col-sm-6 offset-sm-3">
                                    <button id="send" type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update Now
                                    </button>
                                    <a href="<?= base_url('user/all'); ?>" class="btn btn-primary">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {

        //Put your customized page scripts

    });
</script>
