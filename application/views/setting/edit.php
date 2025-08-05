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

                    <h5 class="mt-4"><b>System Info</b></h5>
                    <div class="form-group">
                        <label><b>System Name</b></label>
                        <input type="text" name="name" class="form-control" value="<?= esc($setting->name ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label><b>Slogan</b></label>
                        <input type="text" name="slogan" class="form-control" value="<?= esc($setting->slogan ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label><b>Email</b></label>
                        <input type="email" name="email" class="form-control" value="<?= esc($setting->email ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label><b>Mobile</b></label>
                        <input type="text" name="mobile" class="form-control" value="<?= esc($setting->mobile ?? ''); ?>">
                    </div>
                    <?php $defaultCopyright = 'Copyright © ' . date('Y'); ?>
                    <div class="form-group">
                        <label><b>Copyright</b></label>
                        <input type="text" name="copyright" class="form-control" value="<?= esc($setting->copyright ?? $defaultCopyright); ?>">
                    </div>

                    <h5 class="mt-4"><b>Address Details</b></h5>
                    <div class="form-group">
                        <label><b>Address</b></label>
                        <input type="text" name="address" class="form-control" value="<?= esc($setting->address ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label><b>City</b></label>
                        <input type="text" name="city" class="form-control" value="<?= esc($setting->city ?? ''); ?>">
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
                        <input type="text" name="zip" class="form-control" value="<?= esc($setting->zip ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label><b>Location</b></label>
                        <input type="text" name="location" class="form-control" value="<?= esc($setting->location ?? ''); ?>">
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
                        <input type="text" name="paymentmethod" class="form-control" value="<?= esc($setting->paymentmethod ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label><b>Payment Account</b></label>
                        <input type="text" name="paymentacc" class="form-control" value="<?= esc($setting->paymentacc ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label><b>VAT (%)</b></label>
                        <input type="number" step="0.01" name="vat" class="form-control" value="<?= esc($setting->vat ?? 0); ?>">
                    </div>

                    <h5 class="mt-4"><b>Media / Images</b></h5>
                    <div class="form-group">
                        <label><b>Logo</b></label><br>
                        <?php if (!empty($setting->logo)): ?>
                            <img src="<?= base_url('uploads/' . esc($setting->logo)); ?>" alt="Logo" height="50"><br>
                        <?php endif; ?>
                        <input type="file" name="logo" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label><b>Favicon</b></label><br>
                        <?php if (!empty($setting->favicon)): ?>
                            <img src="<?= base_url('uploads/' . esc($setting->favicon)); ?>" alt="Favicon" height="30"><br>
                        <?php endif; ?>
                        <input type="file" name="favicon" accept="image/*,.ico">
                    </div>

                    <h5 class="mt-4"><b>Entity Details</b></h5>
                    <div class="form-group">
                        <label>Entity ID</label>
                        <input type="text" name="entityid" class="form-control" value="<?= esc($setting->entityid ?? '_NA_'); ?>">
                    </div>

                    <!-- Optional hidden/default system fields -->
                    <input type="hidden" name="sstatus" value="<?= esc($setting->sstatus ?? 'ACTIVE'); ?>">
                    <input type="hidden" name="pid" value="<?= esc($setting->pid ?? 0); ?>">
                    <input type="hidden" name="userid" value="<?= esc($setting->userid ?? 0); ?>">
                    <input type="hidden" name="deleted" value="<?= esc($setting->deleted ?? 0); ?>">

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
