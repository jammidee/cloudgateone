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
                    <div class="col-md-4">
                        <label>Date Range</label>
                        <input type="text" id="dateRange" class="form-control" placeholder="Select range" autocomplete="off">
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

        // Default to this week
        let startDate = moment().startOf('week').format('YYYY-MM-DD');
        let endDate = moment().endOf('week').format('YYYY-MM-DD');

        // Initialize the datepicker
        $('#dateRange').daterangepicker({
            startDate: moment().startOf('week'),
            endDate: moment().endOf('week'),
            autoUpdateInput: true, // Automatically fill the input with selected range
            opens: 'left',
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD'
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'This Week': [moment().startOf('week'), moment().endOf('week')],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()]
            }
        });

        // Set initial input display value
        $('#dateRange').val(startDate + ' to ' + endDate);

        $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
            startDate = picker.startDate.format('YYYY-MM-DD');
            endDate = picker.endDate.format('YYYY-MM-DD');
            $(this).val(startDate + ' to ' + endDate);
            table.ajax.reload();
        });

        $('#dateRange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            startDate = '';
            endDate = '';
            table.ajax.reload();
        });

        const table = $('#dataTableHolder').DataTable({
            responsive: true,
            pageLength: 25,
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= base_url('activitylog/fetchLogs'); ?>",
                type: "POST",
                data: function(d) {
                    d.date_from = startDate;
                    d.date_to = endDate;
                    d.entityid = $('#entityFilter').val();
                }
            },
            order: [[0, 'desc']],
            dom: '<"text-center mb-2"B><"d-flex justify-content-between align-items-center mb-2"l f>rt<"text-center"p>i',
            buttons: canAccessbuttons ? ['copy', 'csv', 'excel', 'pdf', 'print'] : []
        });

        $('#entityFilter').on('keyup change', function () {
            table.ajax.reload();
        });
    });
</script>

