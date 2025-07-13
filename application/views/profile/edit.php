<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/profile/index">Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary mr-3 text-nowrap">Edit Profile</h6>
                </div>
            </div>

            <div class="card-body">
                <form action="<?= base_url('profile/update'); ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Photo Upload -->
                        <div class="col-md-6 mb-3">
                            <label for="photo">Profile Photo</label>
                            <input type="file" class="form-control" name="photo" id="photo">
                        </div>

                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="<?= $user->name ?? ''; ?>">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="<?= $user->email ?? ''; ?>">
                        </div>

                        <!-- Mobile -->
                        <div class="col-md-6 mb-3">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="<?= $user->mobile ?? ''; ?>">
                        </div>

                        <!-- Location -->
                        <div class="col-md-6 mb-3">
                            <label for="location">Location</label>
                            <input type="text" class="form-control" name="location" id="location" placeholder="<?= $user->location ?? ''; ?>">
                        </div>

                        <!-- Area -->
                        <div class="col-md-6 mb-3">
                            <label for="area">Area</label>
                            <input type="text" class="form-control" name="area" id="area" placeholder="<?= $user->area ?? ''; ?>">
                        </div>

                        <!-- Package -->
                        <div class="col-md-6 mb-3">
                            <label for="package">Package</label>
                            <input type="text" class="form-control" name="package" id="package" placeholder="<?= $user->package ?? ''; ?>">
                        </div>

                        <!-- Remarks -->
                        <div class="col-md-6 mb-3">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" placeholder="<?= $user->remarks ?? ''; ?>"></textarea>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password">Password <small class="text-muted">(leave blank to keep current)</small></label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
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
