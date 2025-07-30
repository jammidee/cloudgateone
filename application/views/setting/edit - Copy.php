<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= esc($title ?? '') ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Settings</li>
        </ol>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container-fluid">
                <form method="POST" action="<?= site_url('setting/update/' . ($setting->id ?? '')); ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="<?= esc($setting->name ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Slogan</label>
                        <input type="text" name="slogan" class="form-control" value="<?= esc($setting->slogan ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" name="mobile" class="form-control" value="<?= esc($setting->mobile ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?= esc($setting->email ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Currency</label>
                        <input type="text" name="currency" class="form-control" value="<?= esc($setting->currency ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Payment Method</label>
                        <input type="text" name="paymentmethod" class="form-control" value="<?= esc($setting->paymentmethod ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Payment Account</label>
                        <input type="text" name="paymentacc" class="form-control" value="<?= esc($setting->paymentacc ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>VAT (%)</label>
                        <input type="number" step="0.01" name="vat" class="form-control" value="<?= esc($setting->vat ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>SMS API</label>
                        <input type="text" name="smsapi" class="form-control" value="<?= esc($setting->smsapi ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Email API</label>
                        <input type="text" name="emailapi" class="form-control" value="<?= esc($setting->emailapi ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Send SMS on Bills</label>
                        <select name="smsonbills" class="form-control">
                            <option value="1" <?= !empty($setting->smsonbills) ? 'selected' : '' ?>>Yes</option>
                            <option value="0" <?= empty($setting->smsonbills) ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Send Email on Bills</label>
                        <select name="emailonbills" class="form-control">
                            <option value="1" <?= !empty($setting->emailonbills) ? 'selected' : '' ?>>Yes</option>
                            <option value="0" <?= empty($setting->emailonbills) ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mikrotik IP</label>
                        <input type="text" name="mkipadd" class="form-control" value="<?= esc($setting->mkipadd ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Mikrotik User</label>
                        <input type="text" name="mkuser" class="form-control" value="<?= esc($setting->mkuser ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Mikrotik Password</label>
                        <input type="password" name="mkpassword" class="form-control" value="<?= esc($setting->mkpassword ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" value="<?= esc($setting->address ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" value="<?= esc($setting->city ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" name="country" class="form-control" value="<?= esc($setting->country ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>ZIP</label>
                        <input type="text" name="zip" class="form-control" value="<?= esc($setting->zip ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" value="<?= esc($setting->location ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Copyright</label>
                        <input type="text" name="copyright" class="form-control" value="<?= esc($setting->copyright ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Kenadekha</label>
                        <input type="text" name="kenadekha" class="form-control" value="<?= esc($setting->kenadekha ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Entity ID</label>
                        <input type="text" name="entityid" class="form-control" value="<?= esc($setting->entityid ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Logo (URL or Path)</label>
                        <input type="text" name="logo" class="form-control" value="<?= esc($setting->logo ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Favicon (URL or Path)</label>
                        <input type="text" name="favicon" class="form-control" value="<?= esc($setting->favicon ?? '') ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?= site_url('setting/all?t=' . time()); ?>" class="btn btn-secondary">Cancel</a>
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
