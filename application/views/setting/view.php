<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/setting/all">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
        </ol>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <?php foreach ($view_setting as $setting): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-fw fa-cog"></i> View Settings | <?= esc($setting->name); ?>
                        </h6>
                    </div>
                    <div class="card-body">

                        <div class="text-center mb-4">
                            <?php if (!empty($setting->logo)): ?>
                                <img src="<?= base_url('uploads/' . esc($setting->logo)); ?>" alt="Logo" height="60">
                            <?php endif; ?>
                        </div>

                        <table class="table table-bordered">
                            <tr><th>ID</th><td><?= esc($setting->id ?? '') ?></td></tr>
                            <tr><th>Entity ID</th><td><?= esc($setting->entityid ?? '') ?></td></tr>
                            <tr><th>Name</th><td><?= esc($setting->name ?? '') ?></td></tr>
                            <tr><th>Slogan</th><td><?= esc($setting->slogan ?? '') ?></td></tr>
                            <tr><th>Mobile</th><td><?= esc($setting->mobile ?? '') ?></td></tr>
                            <tr><th>Email</th><td><?= esc($setting->email ?? '') ?></td></tr>
                            <tr><th>Currency</th><td><?= esc($setting->currency ?? '') ?></td></tr>
                            <tr><th>Payment Method</th><td><?= esc($setting->paymentmethod ?? '') ?></td></tr>
                            <tr><th>Payment Account</th><td><?= esc($setting->paymentacc ?? '') ?></td></tr>
                            <tr><th>VAT</th><td><?= esc($setting->vat ?? '') ?>%</td></tr>
                            <tr><th>SMS API</th><td><?= esc($setting->smsapi ?? '') ?></td></tr>
                            <tr><th>Email API</th><td><?= esc($setting->emailapi ?? '') ?></td></tr>
                            <tr><th>SMS on Bills</th><td><?= isset($setting->smsonbills) && $setting->smsonbills ? 'Enabled' : 'Disabled' ?></td></tr>
                            <tr><th>Email on Bills</th><td><?= isset($setting->emailonbills) && $setting->emailonbills ? 'Enabled' : 'Disabled' ?></td></tr>
                            <tr><th>Mikrotik IP</th><td><?= esc($setting->mkipadd ?? '') ?></td></tr>
                            <tr><th>Mikrotik Username</th><td><?= esc($setting->mkuser ?? '') ?></td></tr>
                            <tr><th>Mikrotik Password</th><td><?= esc($setting->mkpassword ?? '') ?></td></tr>
                            <tr><th>Address</th><td><?= esc($setting->address ?? '') ?></td></tr>
                            <tr><th>City</th><td><?= esc($setting->city ?? '') ?></td></tr>
                            <tr><th>Country</th><td><?= esc($setting->country ?? '') ?></td></tr>
                            <tr><th>ZIP</th><td><?= esc($setting->zip ?? '') ?></td></tr>
                            <tr><th>Location</th><td><?= esc($setting->location ?? '') ?></td></tr>

                            <tr><th>Favicon</th>
                                <td>
                                    <?php if (!empty($setting->favicon)): ?>
                                        <img src="<?= base_url('uploads/' . esc($setting->favicon)); ?>" alt="Favicon" height="30">
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr><th>Copyright</th><td><?= esc($setting->copyright); ?></td></tr>
                            <tr><th>Kenadekha</th><td><?= esc($setting->kenadekha); ?></td></tr>
                        </table>

                        <div class="mt-4 text-center">
                            <a href="<?= base_url('setting/edit/' . $setting->id); ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Settings
                            </a>
                            <a href="<?= base_url('setting/all'); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!---Container Fluid--->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Put your customized page scripts here
    });
</script>
