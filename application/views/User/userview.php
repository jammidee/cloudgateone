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

    <!-- <div class="text-center mb-4">
        <img src="<1= base_url('assets/'); ?>img/think.svg" style="max-height: 90px">
        <h4 class="pt-3">Save your <b>imagination</b> On Blank Canvas!</h4>
    </div> -->

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <?php foreach ($view_user as $user): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-fw fa-edit"></i> Vew User | <?= $user->name; ?>
                        </h6>
                    </div>
                    <div class="card-body">

                        <div class="text-center mb-4">
                            <?php if (!empty($user->photo)): ?>
                                <img class="img-profile rounded-circle" width="120" src="<?= base_url('assets/images/final/' . $user->photo); ?>">
                            <?php else: ?>
                                <img class="img-profile rounded-circle" width="120" src="<?= base_url('assets/img/default-avatar.png'); ?>">
                            <?php endif; ?>
                        </div>

                        <table class="table table-bordered">
                            <tr><th>Name</th><td><?= $user->name; ?></td></tr>
                            <tr><th>Mobile</th><td><?= $user->mobile; ?></td></tr>
                            <tr><th>Connection ID</th><td><?= $user->user_id; ?></td></tr>
                            <tr><th>Join Date</th><td><?= $user->join_date; ?></td></tr>
                            <tr><th>Role</th><td><?= $user->role; ?></td></tr>
                            <tr><th>Status</th><td><?= $user->status; ?></td></tr>
                            <?php if (isTechGroup()): ?>
                                <tr><th>Location</th><td><?= $user->location; ?></td></tr>
                                <tr><th>Latitude</th><td><?= $user->lat; ?></td></tr>
                                <tr><th>Longitude</th><td><?= $user->lon; ?></td></tr>
                                <tr><th>PETC Code</th><td><?= $user->petc_code; ?></td></tr>
                                <tr><th>Search Quota</th><td><?= $user->search_quota; ?></td></tr>
                                <tr><th>Search Unlimited</th><td><?= $user->search_unli ? 'Yes' : 'No'; ?></td></tr>
                                <tr><th>Time Unlimited</th><td><?= $user->time_unli ? 'Yes' : 'No'; ?></td></tr>
                                <tr><th>Start Time</th><td><?= $user->starttime; ?></td></tr>
                                <tr><th>End Time</th><td><?= $user->endtime; ?></td></tr>
                            <?php endif; ?>
                            <tr><th>Remarks</th><td><?= $user->remarks; ?></td></tr>
                        </table>

                        <div class="mt-4 text-center">
                            <a href="<?= base_url('user/edit/' . $user->id); ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit User
                            </a>
                            <a href="<?= base_url('user/all'); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {

        //Put your customized page scripts

    });
</script>
