<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/clientdash/index">Client Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Login</li>
        </ol>
    </div>

    <div class="text-center">
        <!-- Centered title and icon -->
        <img src="<?= base_url('assets/'); ?>img/think.svg" style="max-height: 90px">
        <h4 class="pt-3"><b>Client Login Access</b></h4>
    </div>

    <!-- Left-aligned explanatory content -->
    <div class="px-4 pt-3">
        <p>
            The <b>Client Login Module</b> is designed to provide secure access exclusively for registered clients. 
            Through this portal, clients can access their personalized dashboard, review account details, and interact 
            with available services.
        </p>

        <p>
            Login credentials (username and password) are unique to each client and verified through a secure 
            authentication process. The system validates the provided credentials against stored records, ensuring 
            only authorized users are granted access.
        </p>

        <p>
            Once logged in, clients gain access to modules such as <b>billing</b>, <b>requests</b>, <b>notifications</b>, 
            and <b>account management</b>. Session handling ensures that all activities are tracked for security and 
            audit purposes.
        </p>

        <p>
            To enhance security, failed login attempts are logged and can trigger alerts or temporary account lockouts. 
            Clients are encouraged to maintain strong passwords and update them regularly through the account settings.
        </p>

        <p>
            The login page is intended solely for <b>client access</b>. Administrative and staff modules are accessible 
            through a separate portal to maintain system integrity and role-based permissions.
        </p>

        <p>
            Use the <b>Login</b> form to enter your credentials. Upon successful authentication, you will be redirected 
            to your dashboard where you can explore the services available to you.
        </p>
    </div>
</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Custom scripts (if needed)
    });
</script>
