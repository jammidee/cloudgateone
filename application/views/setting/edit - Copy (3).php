<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= esc($title ?? '') ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/setting/all">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container-fluid">
                <form action="<?= base_url('setting/update/' . esc($setting->id ?? '')); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>System Name</label>
                        <input type="text" name="name" class="form-control" value="<?= esc($setting->name ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Slogan</label>
                        <input type="text" name="slogan" class="form-control" value="<?= esc($setting->slogan ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?= esc($setting->email ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" name="mobile" class="form-control" value="<?= esc($setting->mobile ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" value="<?= esc($setting->city ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" name="country" class="form-control" value="<?= esc($setting->country ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Currency</label>
                        <input type="text" name="currency" class="form-control" value="<?= esc($setting->currency ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Payment Method</label>
                        <input type="text" name="paymentmethod" class="form-control" value="<?= esc($setting->paymentmethod ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Payment Account</label>
                        <input type="text" name="paymentacc" class="form-control" value="<?= esc($setting->paymentacc ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>VAT</label>
                        <input type="number" step="0.01" name="vat" class="form-control" value="<?= esc($setting->vat ?? 0); ?>">
                    </div>
                    <div class="form-group">
                        <label>SMS API</label>
                        <input type="text" name="smsapi" class="form-control" value="<?= esc($setting->smsapi ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Email API</label>
                        <input type="text" name="emailapi" class="form-control" value="<?= esc($setting->emailapi ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>SMS on Bills</label>
                        <input type="number" name="smsonbills" class="form-control" value="<?= esc($setting->smsonbills ?? 0); ?>">
                    </div>
                    <div class="form-group">
                        <label>Email on Bills</label>
                        <input type="number" name="emailonbills" class="form-control" value="<?= esc($setting->emailonbills ?? 0); ?>">
                    </div>
                    <div class="form-group">
                        <label>Mikrotik IP Address</label>
                        <input type="text" name="mkipadd" class="form-control" value="<?= esc($setting->mkipadd ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Mikrotik Username</label>
                        <input type="text" name="mkuser" class="form-control" value="<?= esc($setting->mkuser ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Mikrotik Password</label>
                        <input type="password" name="mkpassword" class="form-control" value="<?= esc($setting->mkpassword ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Zip</label>
                        <input type="text" name="zip" class="form-control" value="<?= esc($setting->zip ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" value="<?= esc($setting->location ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Copyright</label>
                        <input type="text" name="copyright" class="form-control" value="<?= esc($setting->copyright ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Kenadekha</label>
                        <input type="text" name="kenadekha" class="form-control" value="<?= esc($setting->kenadekha ?? ''); ?>">
                    </div>
                    <!-- Optional hidden/default system fields -->
                    <input type="hidden" name="sstatus" value="ACTIVE">
                    <input type="hidden" name="pid" value="<?= esc($setting->pid ?? 0); ?>">
                    <input type="hidden" name="userid" value="<?= esc($setting->userid ?? 0); ?>">
                    <input type="hidden" name="deleted" value="0">
                    
                    <div class="form-group">
                        <label>Logo</label><br>
                        <?php if (!empty($setting->logo)): ?>
                            <img src="<?= base_url('uploads/' . esc($setting->logo)); ?>" alt="Logo" height="50"><br>
                        <?php endif; ?>
                        <input type="file" name="logo">
                    </div>
                    <div class="form-group">
                        <label>Favicon</label><br>
                        <?php if (!empty($setting->favicon)): ?>
                            <img src="<?= base_url('uploads/' . esc($setting->favicon)); ?>" alt="Favicon" height="30"><br>
                        <?php endif; ?>
                        <input type="file" name="favicon">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Settings</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!---Container Fluid--->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        //Put your customized page scripts
    });
</script>
