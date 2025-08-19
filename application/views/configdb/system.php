<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/configdb/index">Configdb</a></li>
            <li class="breadcrumb-item active" aria-current="page">System</li>
        </ol>
    </div>

    <div class="text-center">
        <img src="<?= base_url('assets/'); ?>img/think.svg" style="max-height: 90px">
        <h4 class="pt-3">Save your <b>imagination</b> On Blank Canvas!</h4>
    </div>

    <!-- Editable Config Variables -->
    <div class="card mt-4 shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">System Configuration</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('configdb/saveconfig') ?>" method="post">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>Maximum Users</th>
                            <td><input type="number" name="maxusers" class="form-control" value="<?= $maxusers; ?>"></td>
                        </tr>
                        <tr>
                            <th>Site Name</th>
                            <td><input type="text" name="site_name" class="form-control" value="<?= $site_name; ?>"></td>
                        </tr>
                        <tr>
                            <th>Default Timezone</th>
                            <td>
                                <select name="default_timezone" class="form-control">
                                    <option value="UTC" <?= $default_timezone == 'UTC' ? 'selected' : ''; ?>>UTC</option>
                                    <option value="Asia/Manila" <?= $default_timezone == 'Asia/Manila' ? 'selected' : ''; ?>>Asia/Manila</option>
                                    <option value="America/New_York" <?= $default_timezone == 'America/New_York' ? 'selected' : ''; ?>>America/New_York</option>
                                    <!-- Add more if needed -->
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Theme</th>
                            <td>
                                <select name="theme" class="form-control">
                                    <option value="light" <?= $theme == 'light' ? 'selected' : ''; ?>>Light</option>
                                    <option value="dark" <?= $theme == 'dark' ? 'selected' : ''; ?>>Dark</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Session Timeout (minutes)</th>
                            <td><input type="number" name="session_timeout" class="form-control" value="<?= $session_timeout; ?>"></td>
                        </tr>
                        <tr>
                            <th>Default Language</th>
                            <td>
                                <select name="default_language" class="form-control">
                                    <option value="en" <?= $default_language == 'en' ? 'selected' : ''; ?>>English</option>
                                    <option value="es" <?= $default_language == 'es' ? 'selected' : ''; ?>>Spanish</option>
                                    <option value="fr" <?= $default_language == 'fr' ? 'selected' : ''; ?>>French</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Support Email</th>
                            <td><input type="email" name="support_email" class="form-control" value="<?= $support_email; ?>"></td>
                        </tr>
                        <tr>
                            <th>Maintenance Mode</th>
                            <td>
                                <select name="maintenance_mode" class="form-control">
                                    <option value="0" <?= $maintenance_mode == "0" ? "selected" : ""; ?>>Disabled</option>
                                    <option value="1" <?= $maintenance_mode == "1" ? "selected" : ""; ?>>Enabled</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Currency Symbol</th>
                            <td><input type="text" name="currency_symbol" class="form-control" value="<?= $currency_symbol; ?>"></td>
                        </tr>
                        <tr>
                            <th>Records Per Page</th>
                            <td><input type="number" name="records_per_page" class="form-control" value="<?= $records_per_page; ?>"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Editable Config Variables -->

</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Customized scripts
    });
</script>
