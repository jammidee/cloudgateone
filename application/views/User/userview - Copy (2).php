<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/user/all">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary mr-3 text-nowrap">
                        <i class="fas fa-fw fa-user"></i> View User
                    </h6>
                </div>
            </div>
            <div class="card-body">
                <?php foreach ($view_user as $user): ?>
                <!-- View User Info -->
                <div class="row">
                    <!-- ID -->
                    <div class="col-md-6 mb-3">
                        <label>User ID</label>
                        <p class="form-control-plaintext"><?= $user->id; ?></p>
                    </div>

                    <!-- Name -->
                    <div class="col-md-6 mb-3">
                        <label>Full Name</label>
                        <p class="form-control-plaintext"><?= $user->name; ?></p>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <p class="form-control-plaintext"><?= $user->email; ?></p>
                    </div>

                    <!-- Password -->
                    <div class="col-md-6 mb-3">
                        <label>Password</label>
                        <p class="form-control-plaintext text-muted">••••••••</p>
                    </div>

                    <!-- Mobile -->
                    <div class="col-md-6 mb-3">
                        <label>Mobile</label>
                        <p class="form-control-plaintext"><?= $user->mobile; ?></p>
                    </div>

                    <!-- Join Date -->
                    <div class="col-md-6 mb-3">
                        <label>Join Date</label>
                        <p class="form-control-plaintext"><?= $user->join_date; ?></p>
                    </div>

                    <!-- Role -->
                    <div class="col-md-6 mb-3">
                        <label>Role</label>
                        <p class="form-control-plaintext"><?= $user->role; ?></p>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label>Status</label>
                        <p class="form-control-plaintext"><?= $user->status; ?></p>
                    </div>

                    <!-- Remarks -->
                    <div class="col-md-12 mb-12">
                        <label>Remarks</label>
                        <p class="form-control-plaintext"><?= $user->remarks; ?></p>
                    </div>
                </div>

                <br>
                <div class="text-right">
                    <a href="<?= base_url('user/all'); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!---Container Fluid-->

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Put your customized page scripts
});
</script>
