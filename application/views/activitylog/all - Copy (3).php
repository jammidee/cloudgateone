<?php
/**
 * Adjusted `all.php` view to support:
 * - Date range filter (Today, This Week, This Month, Custom)
 * - Entity ID filter
 * - Server-side DataTable
 */
?>

<!-- Container Fluid -->
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

            <div class="p-3">
                <div class="form-row mb-3">
                    <div class="col-md-3">
                        <label>Date Filter</label>
                        <select id="dateFilter" class="form-control">
                            <option value="">All</option>
                            <option value="today">Today</option>
                            <option value="this_week">This Week</option>
                            <option value="this_month">This Month</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-none" id="customDateRange">
                        <label>From</label>
                        <input type="date" id="fromDate" class="form-control">
                    </div>
                    <div class="col-md-3 d-none" id="customDateRangeTo">
                        <label>To</label>
                        <input type="date" id="toDate" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Entity ID</label>
                        <input type="text" id="entityFilter" class="form-control" placeholder="Enter entityid">
                    </div>
                </div>
            </div>

            <div class="table-responsive p-3">
                <table class="table table-sm align-items-center table-flush table-hover display nowrap" id="dataTableHolder" style="width:100%">
                    <thead class="thead-light">
                        <tr>
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
                    <tbody></tbody>
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

        const table = $('#dataTableHolder').DataTable({
            responsive: true,
            pageLength: 25,
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= base_url('activitylog/fetchLogs'); ?>",
                type: "POST",
                data: function(d) {
                    d.dateFilter = $('#dateFilter').val();
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                    d.entityid = $('#entityFilter').val();
                }
            },
            order: [[0, 'desc']],
            dom: '<"text-center mb-2"B><"d-flex justify-content-between align-items-center mb-2"l f>rt<"text-center"p>i',
            buttons: canAccessbuttons ? ['copy', 'csv', 'excel', 'pdf', 'print'] : []
        });

        $('#dateFilter').on('change', function() {
            const val = $(this).val();
            if (val === 'custom') {
                $('#customDateRange, #customDateRangeTo').removeClass('d-none');
            } else {
                $('#customDateRange, #customDateRangeTo').addClass('d-none');
                $('#fromDate').val('');
                $('#toDate').val('');
            }
            table.ajax.reload();
        });

        $('#fromDate, #toDate, #entityFilter').on('change keyup', function () {
            table.ajax.reload();
        });
    });
</script>
