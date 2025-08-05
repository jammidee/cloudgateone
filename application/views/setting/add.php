<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= esc($title ?? '') ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/setting/all">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container-fluid">
                <form action="<?= base_url('setting/store'); ?>" method="post" enctype="multipart/form-data">

                    <h5 class="mt-4"><b>System Info</b></h5>
                    <div class="form-group">
                        <label><b>System Name</b></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter system name" value="<?= esc($setting->name ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label><b>Slogan</b></label>
                        <input type="text" name="slogan" class="form-control" placeholder="Enter slogan" value="<?= esc($setting->slogan ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label><b>Email</b></label>
                        <input type="email" name="email" class="form-control" placeholder="Enter contact email" value="<?= esc($setting->email ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label><b>Mobile</b></label>
                        <input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" value="<?= esc($setting->mobile ?? ''); ?>">
                    </div>
                    <?php
                        $defaultCopyright = 'Copyright © ' . date('Y');
                    ?>
                    <div class="form-group">
                        <label><b>Copyright</b></label>
                        <input type="text" name="copyright" class="form-control" placeholder="Enter copyright notice" value="<?= esc($setting->copyright ?? $defaultCopyright); ?>">
                    </div>

                    <h5 class="mt-4"><b>Address Details</b></h5>
                    <div class="form-group">
                        <label><b>Address</b></label>
                        <input type="text" name="address" class="form-control" placeholder="Enter address" value="<?= esc($setting->address ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label><b>City</b></label>
                        <input type="text" name="city" class="form-control" placeholder="Enter city name" value="<?= esc($setting->city ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label><b>Country</b></label>
                        <select name="country" class="form-control" required>
                            <option value="">-- Select Country --</option>
                            <?php foreach ($countries as $country): ?>
                                <option value="<?= esc($country->itemid); ?>"
                                    <?= isset($setting->country) && $setting->country == $country->itemid ? 'selected' : '' ?>>
                                    <?= esc($country->description); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><b>ZIP Code</b></label>
                        <input type="text" name="zip" class="form-control" placeholder="Enter ZIP code" value="<?= esc($setting->zip ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label><b>Location</b></label>
                        <input type="text" name="location" class="form-control" placeholder="Enter location or landmark" value="<?= esc($setting->location ?? ''); ?>">
                    </div>

                    <h5 class="mt-4"><b>Financial Details</b></h5>
                    <div class="form-group">
                        <label><b>Currency</b></label>
                        <select name="currency" class="form-control" required>
                            <option value="">-- Select Currency --</option>
                            <?php foreach ($currencies as $currency): ?>
                                <option value="<?= esc($currency->itemid); ?>"
                                    <?= isset($setting->currency) && $setting->currency == $currency->itemid ? 'selected' : '' ?>>
                                    <?= esc($currency->description); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><b>Payment Method</b></label>
                        <input type="text" name="paymentmethod" class="form-control" placeholder="Enter payment method (e.g. GCash, Bank)" value="<?= esc($setting->paymentmethod ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label><b>Payment Account</b></label>
                        <input type="text" name="paymentacc" class="form-control" placeholder="Enter account name or number" value="<?= esc($setting->paymentacc ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label><b>VAT (%)</b></label>
                        <input type="number" step="0.01" name="vat" class="form-control" placeholder="Enter VAT percentage e.g. 12%" value="<?= esc($setting->vat ?? 12); ?>">
                    </div>

                    <!-- <div class="form-group">
                        <label>SMS API</label>
                        <input type="text" name="smsapi" class="form-control" placeholder="Enter SMS API key or URL" value="<!= esc($setting->smsapi ?? ''); ?>">
                    </div> -->
                    <!-- <div class="form-group">
                        <label>Email API</label>
                        <input type="text" name="emailapi" class="form-control" placeholder="Enter email API key or SMTP info" value="<!= esc($setting->emailapi ?? ''); ?>">
                    </div> -->
                    <!-- <div class="form-group">
                        <label>SMS on Bills</label>
                        <select name="smsonbills" class="form-control">
                            <option value="1" <!= isset($setting->smsonbills) && $setting->smsonbills ? 'selected' : '' ?>>Enabled</option>
                            <option value="0" <!= isset($setting->smsonbills) && !$setting->smsonbills ? 'selected' : '' ?>>Disabled</option>
                        </select>
                    </div> -->
                    <!-- <div class="form-group">
                        <label>Email on Bills</label>
                        <select name="emailonbills" class="form-control">
                            <option value="1" <!= isset($setting->emailonbills) && $setting->emailonbills ? 'selected' : '' ?>>Enabled</option>
                            <option value="0" <!= isset($setting->emailonbills) && !$setting->emailonbills ? 'selected' : '' ?>>Disabled</option>
                        </select>
                    </div> -->
                    <!-- <div class="form-group">
                        <label>Mikrotik IP</label>
                        <input type="text" name="mkipadd" class="form-control" placeholder="Enter Mikrotik IP address" value="<!= esc($setting->mkipadd ?? ''); ?>">
                    </div> -->
                    <!-- <div class="form-group">
                        <label>Mikrotik Username</label>
                        <input type="text" name="mkuser" class="form-control" placeholder="Enter Mikrotik username" value="<!= esc($setting->mkuser ?? ''); ?>">
                    </div> -->
                    <!-- <div class="form-group">
                        <label>Mikrotik Password</label>
                        <input type="password" name="mkpassword" class="form-control" placeholder="Enter Mikrotik password" value="<!= esc($setting->mkpassword ?? ''); ?>">
                    </div> -->
                    <!-- <div class="form-group">
                        <label>Kena Dekha</label>
                        <input type="text" name="kenadekha" class="form-control" placeholder="Optional notes or tag line" value="<!= esc($setting->kenadekha ?? ''); ?>">
                    </div> -->
                    <h5 class="mt-4"><b>Media / Images</b></h5>
                    <div class="form-group">
                        <label><b>Logo</b></label><br>
                        <input type="file" name="logo" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label><b>Favicon</b></label><br>
                        <input type="file" name="favicon" accept="image/*,.ico">
                    </div>

                    <h5 class="mt-4"><b>Entity Details</b></h5>
                    <div class="form-group">
                        <label><b>Entity ID</b></label>
                        <input type="text" name="entityid" class="form-control" placeholder="Enter entity ID" value="<?= esc($setting->entityid ?? ''); ?>">
                    </div>
                    <button type="submit" class="btn btn-success">Save Settings</button>
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
