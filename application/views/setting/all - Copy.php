<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/setting/index">System Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Settings</li>
        </ol>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Settings List</h6>

            <?php if (canAccessMenu('setting_update', $this->session->userdata('user_role'))): ?>
                <a href="<?= site_url('setting/edit/1'); ?>" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit mr-1"></i> Edit Settings
                </a>
            <?php endif; ?>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-items-center table-flush table-hover display nowrap" id="dataTableSetting" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slogan</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Currency</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($settings as $setting): ?>
                        <tr>
                            <td><?= htmlspecialchars($setting->id ?? '') ?></td>
                            <td><?= htmlspecialchars($setting->name ?? '') ?></td>
                            <td><?= htmlspecialchars($setting->slogan ?? '') ?></td>
                            <td><?= htmlspecialchars($setting->email ?? '') ?></td>
                            <td><?= htmlspecialchars($setting->mobile ?? '') ?></td>
                            <td><?= htmlspecialchars($setting->currency ?? '') ?></td>
                            <td><?= htmlspecialchars($setting->city ?? '') ?></td>
                            <td><?= htmlspecialchars($setting->country ?? '') ?></td>
                            <td>
                                <?php if (canAccessMenu('setting_update', $this->session->userdata('user_role'))): ?>
                                    <a href="<?= base_url('setting/edit/' . $setting->id); ?>" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<!-- End Container Fluid -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const canAccessSettingReport = <?= canAccessMenu('setting_report', $this->session->userdata('user_role')) ? 'true' : 'false' ?>;

        if ($('#dataTableSetting').length) {
            $('#dataTableSetting').DataTable({
                responsive: true,
                pageLength: 25,
                lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
                order: [],
                dom: '<"text-center mb-2"B><"d-flex justify-content-between align-items-center mb-2"l f>rt<"text-center"p>i',
                buttons: canAccessSettingReport ? ['copy', 'csv', 'excel', 'pdf', 'print'] : [],
                columnDefs: [{
                    targets: 'nosort',
                    orderable: false
                }]
            });
        }
    });
</script>
