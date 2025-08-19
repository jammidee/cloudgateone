<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/configdb/system">Configdb</a></li>
            <li class="breadcrumb-item active" aria-current="page">Index</li>
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
                <h4 class="pt-3"><b>Configuration Database Module</b></h4>
            </div>

            <div class="px-4 pt-3">
                <p>
                    The <strong>Configuration Database (Config DB)</strong> module provides administrators with a centralized interface to manage critical system settings, parameters, and application-level preferences.
                    It ensures that the entire system operates consistently based on controlled and versioned configurations.
                </p>

                <p>
                    This module acts as the <em>single source of truth</em> for environment variables, system parameters, integration settings, and feature toggles. Instead of hardcoding or scattering settings across multiple files,
                    administrators can update them in one place, ensuring reliability and traceability.
                </p>

                <p>
                    Config DB supports structured categorization of settings, such as:
                </p>
                <ul>
                    <li><strong>System Settings</strong> – General properties like application name, default timezone, or system language.</li>
                    <li><strong>Security Settings</strong> – Authentication rules, session lifetimes, password policies, and encryption preferences.</li>
                    <li><strong>Integration Settings</strong> – API keys, external service endpoints, and database connection details.</li>
                    <li><strong>Feature Flags</strong> – Enable or disable experimental modules, beta features, or conditional workflows.</li>
                </ul>

                <p>
                    Using this module, administrators can easily <strong>add new configurations</strong>, <strong>update existing values</strong>, or <strong>deactivate unused entries</strong>. Each modification is tracked,
                    helping maintain audit trails and accountability.
                </p>

                <p>
                    By centralizing configuration management, the Config DB enhances consistency, reduces risk of misconfiguration, and improves system scalability.
                    It is a vital tool for both day-to-day operations and long-term system governance.
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
