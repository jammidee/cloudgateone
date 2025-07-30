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
                        <label>Logo</label><br>
                        <input type="file" name="logo">
                    </div>
                    <div class="form-group">
                        <label>Favicon</label><br>
                        <input type="file" name="favicon">
                    </div>
                    <div class="form-group">
                        <label>Entity ID</label>
                        <input type="text" name="entityid" class="form-control" value="<?= esc($setting->entityid ?? ''); ?>">
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
        //Put your customized page scripts
    });
</script>
