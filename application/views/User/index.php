<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/user/all">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">User</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                <div class="d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary mr-3 text-nowrap">Help</h6>
                </div>

            </div>

            <div class="text-center">
                <!-- Centered title and icon -->
                <img src="<?= base_url('assets/'); ?>img/think.svg" style="max-height: 90px">
                <h4 class="pt-3"><b>User Management Module</b></h4>
            </div>

            <div class="px-4 pt-3">
                <p>
                    The <strong>User Management Module</strong> provides administrators with a centralized interface for managing user accounts and access control across the application.
                    It allows for the creation, updating, and deactivation of user profiles while enforcing role-based access and system security.
                </p>

                <p>
                    This module supports managing user details such as personal information, login credentials, assigned roles, status, and access limitations (e.g., search or time restrictions).
                    It ensures that only authorized personnel have the appropriate access levels, which helps maintain data privacy and operational integrity.
                </p>

                <p>
                    Users can be categorized based on roles (e.g., Admin, Manager, Support, User), status (e.g., Active, Inactive), and location-specific metadata. These attributes can be updated easily as responsibilities change or new users are onboarded.
                </p>

                <p>
                    Use the <strong>Add</strong> button to register a new user. Existing users can be edited to reflect role updates, connection credentials, or restrictions. This module plays a key role in enforcing organizational policies and user accountability.
                </p>
            </div>


        </div>
    </div>


</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {

        //Put your customized page scripts

    });
</script>