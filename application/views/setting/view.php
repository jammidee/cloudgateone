<!-- Container Fluid -->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('setting'); ?>">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
        </ol>
    </div>

    <?php if ($setting): ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4 shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Setting Details | ID #<?= $setting->id; ?></h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr><th>Logo</th><td><?= htmlspecialchars($setting->logo ?? 'N/A') ?></td></tr>
                                <tr><th>Favicon</th><td><?= htmlspecialchars($setting->favicon ?? 'N/A') ?></td></tr>
                                <tr><th>Name</th><td><?= htmlspecialchars($setting->name ?? 'N/A') ?></td></tr>
                                <tr><th>Slogan</th><td><?= htmlspecialchars($setting->slogan ?? 'N/A') ?></td></tr>
                                <tr><th>Mobile</th><td><?= htmlspecialchars($setting->mobile ?? 'N/A') ?></td></tr>
                                <tr><th>Email</th><td><?= htmlspecialchars($setting->email ?? 'N/A') ?></td></tr>
                                <tr><th>Currency</th><td><?= htmlspecialchars($setting->currency ?? 'N/A') ?></td></tr>
                                <tr><th>Payment Method</th><td><?= htmlspecialchars($setting->paymentmethod ?? 'N/A') ?></td></tr>
                                <tr><th>Payment Account</th><td><?= htmlspecialchars($setting->paymentacc ?? 'N/A') ?></td></tr>
                                <tr><th>VAT (%)</th><td><?= number_format($setting->vat ?? 0, 2) ?></td></tr>
                                <tr><th>SMS API</th><td><?= htmlspecialchars($setting->smsapi ?? 'N/A') ?></td></tr>
                                <tr><th>Email API</th><td><?= htmlspecialchars($setting->emailapi ?? 'N/A') ?></td></tr>
                                <tr><th>Send SMS on Bills</th><td><?= $setting->smsonbills ? 'Yes' : 'No' ?></td></tr>
                                <tr><th>Send Email on Bills</th><td><?= $setting->emailonbills ? 'Yes' : 'No' ?></td></tr>
                                <tr><th>Mikrotik IP</th><td><?= htmlspecialchars($setting->mkipadd ?? 'N/A') ?></td></tr>
                                <tr><th>Mikrotik User</th><td><?= htmlspecialchars($setting->mkuser ?? 'N/A') ?></td></tr>
                                <tr><th>Mikrotik Password</th><td><?= htmlspecialchars($setting->mkpassword ?? 'N/A') ?></td></tr>
                                <tr><th>Address</th><td><?= htmlspecialchars($setting->address ?? 'N/A') ?></td></tr>
                                <tr><th>City</th><td><?= htmlspecialchars($setting->city ?? 'N/A') ?></td></tr>
                                <tr><th>Country</th><td><?= htmlspecialchars($setting->country ?? 'N/A') ?></td></tr>
                                <tr><th>ZIP</th><td><?= htmlspecialchars($setting->zip ?? 'N/A') ?></td></tr>
                                <tr><th>Location</th><td><?= htmlspecialchars($setting->location ?? 'N/A') ?></td></tr>
                                <tr><th>Copyright</th><td><?= htmlspecialchars($setting->copyright ?? 'N/A') ?></td></tr>
                                <tr><th>Kenadekha</th><td><?= htmlspecialchars($setting->kenadekha ?? 'N/A') ?></td></tr>
                            </tbody>
                        </table>

                        <div class="mt-4 text-center">
                            <a href="<?= base_url('setting/edit/' . $setting->id) . '?t=' . time(); ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Setting
                            </a>
                            <a href="<?= base_url('setting/all?t=' . time()); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">No setting record found.</div>
    <?php endif; ?>
</div>
<!-- End of Container Fluid -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Custom JS (if needed)
    });
</script>
