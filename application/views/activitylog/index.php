<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/activitylog/index">Activity Log</a></li>
            <li class="breadcrumb-item active" aria-current="page">Index</li>
        </ol>
    </div>

    <div class="text-center">
        <!-- Centered title and icon -->
        <img src="<?= base_url('assets/'); ?>img/think.svg" style="max-height: 90px">
        <h4 class="pt-3"><b>Activity Log Module</b></h4>
    </div>

    <!-- Left-aligned explanatory content -->
    <div class="px-4 pt-3">
        <p>
            The <b>Activity Log</b> provides a detailed history of user actions and system events associated with your account.
            This feature helps track significant activities such as logins, updates, deletions, access to sensitive modules, and other operations performed within the application.
        </p>

        <p>
            Monitoring activity logs enhances transparency, accountability, and security across the system.
            It allows users and administrators to verify actions taken, identify suspicious behavior, and audit historical changes when necessary.
        </p>

        <p>
            The information displayed here may include the action type, timestamp, user role, IP address, and other relevant context tied to each logged event.
        </p>

        <p>
            This log is read-only and cannot be modified. For concerns regarding specific entries, please contact the system administrator or support team.
        </p>
    </div>



</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {

        //Put your customized page scripts

    });
</script>