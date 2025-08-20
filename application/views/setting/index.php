<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/setting/all">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Index</li>
        </ol>
    </div>

    <div class="text-center">
        <!-- Centered title and icon -->
        <img src="<?= base_url('assets/'); ?>img/settings.svg" style="max-height: 90px">
        <h4 class="pt-3"><b>Settings Module</b></h4>
    </div>

    <!-- Left-aligned explanatory content -->
    <div class="px-4 pt-3">
        <p>
            The Settings Module is used to manage global configurations of the application, such as branding, contact information, system slogans, and other core identifiers.
            This ensures that any system-wide change (like the app name or logo) can be managed from a single interface without needing to modify individual files or templates manually.
        </p>

        <p>
            Administrators can update essential application information like the logo, favicon, system name, contact number, and email from this centralized interface.
            This enhances maintainability and enforces consistency throughout the application.
        </p>

        <p>
            All changes made in the settings module are reflected dynamically across the system, helping streamline administrative tasks and enabling rapid branding or configuration updates.
        </p>

        <p>
            Use the <b>Edit</b> button to modify system configurations. Make sure to input accurate and up-to-date information, as these settings are accessed by many parts of the system.
        </p>
    </div>
</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        //Put your customized page scripts
    });
</script>
