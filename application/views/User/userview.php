<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('user/all'); ?>">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
        </ol>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container-fluid">
                <?php foreach ($view_user as $user): ?>

                <!-- Header -->
                <div class="text-center mb-4">
                    <h2 class="font-weight-bold">User Profile</h2>
                    <p class="text-muted">User ID: <?= esc($user->id) ?></p>
                    <hr>
                </div>

                <!-- Basic Information -->
                <h5 class="mb-2"><strong>Basic Information</strong></h5>
                <table class="table table-bordered table-sm">
                    <tr>
                        <th width="20%">Full Name</th>
                        <td><?= esc($user->name) ?></td>
                        <th width="20%">Email</th>
                        <td><?= esc($user->email) ?></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td class="text-muted">••••••••</td>
                        <th>Mobile</th>
                        <td><?= esc($user->mobile) ?></td>
                    </tr>
                </table>

                <!-- Membership -->
                <h5 class="mt-4 mb-2"><strong>Membership</strong></h5>
                <table class="table table-bordered table-sm">
                    <tr>
                        <th width="20%">Join Date</th>
                        <td><?= esc($user->join_date) ?></td>
                        <th>Role</th>
                        <td><?= esc($user->role) ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td colspan="3">
                            <span class="badge
                                <?= $user->status == 'Active' ? 'badge-success' : '' ?>
                                <?= $user->status == 'Inactive' ? 'badge-secondary' : '' ?>">
                                <?= esc($user->status) ?>
                            </span>
                        </td>
                    </tr>
                </table>

                <!-- Remarks -->
                <h5 class="mt-4 mb-2"><strong>Remarks</strong></h5>
                <div class="border p-2">
                    <?= !empty($user->remarks) ? nl2br(esc($user->remarks)) : 'None' ?>
                </div>

                <br>
                <!-- Actions -->
                <div class="mt-4 d-print-none text-right">
                    <a href="<?= site_url('user/all?t=') . time(); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    <a href="<?= site_url('user/edit/' . $user->id) . '?t=' . time(); ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!-- End of Container Fluid -->
