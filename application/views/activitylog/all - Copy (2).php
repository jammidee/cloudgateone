<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/activitylog/index">System Logs</a></li>
            <li class="breadcrumb-item active" aria-current="page">All</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-alt text-primary mr-2"></i>
                    <h6 class="m-0 font-weight-bold text-primary mr-3">Activity Logs</h6>
                </div>
            </div>

            <div class="table-responsive p-3">
                <table class="table table-sm align-items-center table-flush table-hover display nowrap" id="dataTableHolder" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <!-- <th style="width: 5%;">ID</th> -->
                            <th style="width: 10%;">Time</th>
                            <th style="width: 10%;">User ID</th>
                            <th style="width: 10%;">Type</th>
                            <th style="width: 10%;">IP</th>
                            <th style="width: 5%;">Suspicious</th>
                            <th style="width: 10%;">Severity</th>
                            <th style="width: 30%;">Details</th>
                            <th style="width: 10%;">Agent</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Time</th>
                            <th>User ID</th>
                            <th>Type</th>
                            <th>IP</th>
                            <th>Suspicious</th>
                            <th>Severity</th>
                            <th>Details</th>
                            <th>Agent</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <!-- <td><!= $log->id; ?></td> -->
                                <td><?= date('Y-m-d H:i:s', strtotime($log->created_at)); ?></td>
                                <td><?= $log->user_id ?? '<i class="text-muted">Guest</i>'; ?></td>
                                <td><?= ucfirst($log->action_type); ?></td>
                                <td><?= $log->ip_address; ?></td>
                                <td><?= $log->is_suspicious ? '<span class="text-danger">Yes</span>' : 'No'; ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $log->severity === 'ERROR' ? 'badge-danger' : ($log->severity === 'WARNING' ? 'badge-warning' : 'badge-success'); ?>">
                                        <?= $log->severity; ?>
                                    </span>
                                </td>
                                <td><?= htmlentities($log->action_details); ?></td>
                                <td><?= wordwrap(htmlentities($log->user_agent), 30, "<br>"); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="text-right mt-3 mb-4">
                    <a href="<?= base_url('activitylog/rotatelogs'); ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Are you sure you want to rotate logs? Old records will be deleted or archived.');">
                        <i class="fas fa-recycle"></i> Rotate Logs
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const canAccessbuttons = <?= canAccessMenu('user_report', $this->session->userdata('user_role')) ? 'true' : 'false' ?>;

        if (typeof jQuery === "undefined") {
            console.error("jQuery is not loaded. DataTables requires jQuery.");
            return;
        }

        if ($('#dataTableHolder').length) {
            $('#dataTableHolder').DataTable({
                responsive: true,
                pageLength: 25,
                lengthMenu: [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"] ],
                order: [[0, 'desc']],
                dom: '<"text-center mb-2"B><"d-flex justify-content-between align-items-center mb-2"l f>rt<"text-center"p>i',
                buttons: canAccessbuttons ? ['copy', 'csv', 'excel', 'pdf', 'print'] : [],
                columnDefs: [{
                    targets: 'nosort',
                    orderable: false
                }],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?= base_url('activitylog/fetchLogs'); ?>",
                    "type": "POST"
                }
            });
        } else {
            console.warn("#dataTableHolder table not found.");
        }

    });
</script>
