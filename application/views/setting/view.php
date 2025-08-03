<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= esc($title); ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/setting/all">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
        </ol>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-fw fa-cog"></i> View Settings | <?= esc($view_setting->name); ?>
                    </h6>
                </div>
                <div class="card-body">

                    <div class="text-center mb-4">
                        <?php if (!empty($view_setting->logo)): ?>
                            <img src="<?= base_url('uploads/' . esc($view_setting->logo)); ?>" alt="Logo" height="60">
                        <?php endif; ?>
                    </div>

                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr><th colspan="2">General Info</th></tr>
                        </thead>
                        <tr><th>ID</th><td><?= esc($view_setting->id) ?></td></tr>
                        <tr><th>Entity ID</th><td><?= esc($view_setting->entityid) ?></td></tr>
                        <tr><th>Name</th><td><?= esc($view_setting->name) ?></td></tr>
                        <tr><th>Slogan</th><td><?= esc($view_setting->slogan) ?></td></tr>

                        <thead class="thead-light">
                            <tr><th colspan="2">Contact Info</th></tr>
                        </thead>
                        <tr><th>Mobile</th><td><?= esc($view_setting->mobile) ?></td></tr>
                        <tr><th>Email</th><td><?= esc($view_setting->email) ?></td></tr>

                        <thead class="thead-light">
                            <tr><th colspan="2">Financial Info</th></tr>
                        </thead>
                        <tr><th>Currency</th><td><?= esc($view_setting->currency) ?></td></tr>
                        <tr><th>Payment Method</th><td><?= esc($view_setting->paymentmethod) ?></td></tr>
                        <tr><th>Payment Account</th><td><?= esc($view_setting->paymentacc) ?></td></tr>
                        <tr><th>VAT</th><td><?= esc($view_setting->vat) ?>%</td></tr>

                        <!-- <thead class="thead-light">
                            <tr><th colspan="2">Billing Settings</th></tr>
                        </thead> -->
                        <!-- <tr><th>SMS API</th><td><!= esc($view_setting->smsapi) ?></td></tr> -->
                        <!-- <tr><th>Email API</th><td><!= esc($view_setting->emailapi) ?></td></tr> -->
                        <!-- <tr><th>SMS on Bills</th><td><!= $view_setting->smsonbills ? 'Enabled' : 'Disabled' ?></td></tr> -->
                        <!-- <tr><th>Email on Bills</th><td><!= $view_setting->emailonbills ? 'Enabled' : 'Disabled' ?></td></tr> -->

                        <!-- <thead class="thead-light">
                            <tr><th colspan="2">Mikrotik Info</th></tr>
                        </thead> -->
                        <!-- <tr><th>IP Address</th><td><!= esc($view_setting->mkipadd) ?></td></tr> -->
                        <!-- <tr><th>Username</th><td><!= esc($view_setting->mkuser) ?></td></tr> -->
                        <!-- <tr><th>Password</th><td><!= esc($view_setting->mkpassword) ?></td></tr> -->

                        <thead class="thead-light">
                            <tr><th colspan="2">Address Info</th></tr>
                        </thead>
                        <tr><th>Address</th><td><?= esc($view_setting->address) ?></td></tr>
                        <tr><th>City</th><td><?= esc($view_setting->city) ?></td></tr>
                        <tr><th>Country</th><td><?= esc($view_setting->country) ?></td></tr>
                        <tr><th>ZIP</th><td><?= esc($view_setting->zip) ?></td></tr>
                        <tr><th>Location</th><td><?= esc($view_setting->location) ?></td></tr>

                        <thead class="thead-light">
                            <tr><th colspan="2">Media</th></tr>
                        </thead>
                        <tr>
                            <th>Favicon</th>
                            <td>
                                <?php if (!empty($view_setting->favicon)): ?>
                                    <img src="<?= base_url('uploads/' . esc($view_setting->favicon)); ?>" alt="Favicon" height="30">
                                <?php endif; ?>
                            </td>
                        </tr>

                        <thead class="thead-light">
                            <tr><th colspan="2">Miscellaneous</th></tr>
                        </thead>
                        <tr><th>Copyright</th><td><?= esc($view_setting->copyright) ?></td></tr>
                        <!-- <tr><th>Kenadekha</th><td><!= esc($view_setting->kenadekha) ?></td></tr> -->
                        <!-- <tr><th>Status</th><td><!= esc($view_setting->sstatus) ?></td></tr> -->
                        <!-- <tr><th>PID</th><td><!= esc($view_setting->pid) ?></td></tr> -->
                        <!-- <tr><th>User ID</th><td><!= esc($view_setting->userid) ?></td></tr> -->
                        <!-- <tr><th>Deleted</th><td><!= $view_setting->deleted ? 'Yes' : 'No' ?></td></tr> -->
                    </table>

                    <div class="mt-4 text-center">
                        <a href="<?= base_url('setting/edit/' . $view_setting->id); ?>" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Settings
                        </a>
                        <a href="<?= base_url('setting/all'); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!---Container Fluid--->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Put your customized page scripts here
    });
</script>
