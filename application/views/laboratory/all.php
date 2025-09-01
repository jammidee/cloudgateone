<!-- Container Fluid -->
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item"><a href="/laboratory/index">Laboratory</a></li>
      <li class="breadcrumb-item active" aria-current="page">All Records</li>
    </ol>
  </div>

  <?php $isDesktop = !preg_match('/(android|iphone|ipad|mobile)/i', $_SERVER['HTTP_USER_AGENT']); ?>

  <div class="col-lg-12">
    <div class="card mb-4">
      <?php if ($isDesktop): ?>
      <!-- Desktop / Large Display Layout -->
      <div class="card-header py-3 d-flex align-items-center justify-content-between flex-wrap">
        <!-- Left: Icon + Title -->
        <div class="d-flex align-items-center mr-3">
          <i class="fas fa-vials text-primary mr-2"></i>
          <h6 class="m-0 font-weight-bold text-primary">Laboratory Records</h6>
        </div>

        <!-- Middle: Filters -->
        <div class="d-flex align-items-center flex-wrap">
          <div class="d-flex align-items-center mr-3">
            <label class="mb-0 mr-2" style="white-space: nowrap;" for="dateRange">Date-Range</label>
            <input type="text" id="dateRange" class="form-control form-control-sm" style="width: 180px;"
              placeholder="Select range" autocomplete="off">
          </div>
          <div class="d-flex align-items-center mr-3">
            <label class="mb-0 mr-2" style="white-space: nowrap;" for="entityFilter">Entity-ID</label>
            <input type="text" id="entityFilter" class="form-control form-control-sm"
              value="<?= esc($this->session->userdata('user_entity')) ?>" readonly>
          </div>
        </div>

        <!-- Right: Button -->
        <?php if (canAccessMenu('laboratory_create', $this->session->userdata('user_role'))): ?>
        <a href="<?= site_url('laboratory/create'); ?>" class="btn btn-sm btn-primary ml-auto">
          <i class="fas fa-plus mr-1"></i> New Record
        </a>
        <?php endif; ?>
      </div>
      <?php else: ?>
      <!-- Mobile Layout -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <i class="fas fa-vials text-primary mr-2"></i>
          <h6 class="m-0 font-weight-bold text-primary">Laboratory Records</h6>
        </div>
        <?php if (canAccessMenu('laboratory_create', $this->session->userdata('user_role'))): ?>
        <a href="<?= site_url('laboratory/create'); ?>" class="btn btn-sm btn-primary">
          <i class="fas fa-plus mr-1"></i> New Record
        </a>
        <?php endif; ?>
      </div>

      <div class="p-3">
        <div class="form-row mb-3">
          <div class="col-md-4">
            <label>Date Range</label>
            <input type="text" id="dateRange" class="form-control" placeholder="Select range" autocomplete="off">
          </div>
          <div class="col-md-3">
            <label>Entity ID</label>
            <input type="text" id="entityFilter" class="form-control"
              value="<?= esc($this->session->userdata('user_entity')) ?>" readonly>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <div class="table-responsive p-3">
        <table class="table table-sm align-items-center table-flush table-hover display nowrap"
          id="dataTableLaboratory" style="width:100%">
          <thead class="thead-light">
            <tr>
              <th>ID</th> <!-- 👈 will be hidden -->
              <th>Date</th>
              <th>Patient</th>
              <th>Doctor</th>
              <th>Category</th>
              <th>Report</th>
              <th>Status</th>
              <th>Age</th> <!-- 👈 new column -->
              <th>Actions</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- End Container Fluid -->

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const canExport = <?= canAccessMenu('laboratory_report', $this->session->userdata('user_role')) ? 'true' : 'false' ?>;

    // Default to current week
    let startDate = moment().startOf('week').format('YYYY-MM-DD');
    let endDate = moment().endOf('week').format('YYYY-MM-DD');

    // Date range picker
    $('#dateRange').daterangepicker({
      startDate: moment().startOf('week'),
      endDate: moment().endOf('week'),
      autoUpdateInput: true,
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

    $('#dateRange').val(startDate + ' to ' + endDate);

    $('#dateRange').on('apply.daterangepicker', function (ev, picker) {
      startDate = picker.startDate.format('YYYY-MM-DD');
      endDate = picker.endDate.format('YYYY-MM-DD');
      $(this).val(startDate + ' to ' + endDate);
      table.ajax.reload();
    });

    $('#dateRange').on('cancel.daterangepicker', function (ev, picker) {
      $(this).val('');
      startDate = '';
      endDate = '';
      table.ajax.reload();
    });

    const table = $('#dataTableLaboratory').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: {
            url: "<?= base_url('laboratory/fetchAllAjax'); ?>",
            type: "POST",
            data: function (d) {
              d.date_from = startDate;
              d.date_to = endDate;
              d.entityid = $('#entityFilter').val();
              d.searchText = d.search.value;
            }
        },
        dom: '<"text-center mb-2"B><"d-flex justify-content-between align-items-center mb-2"lf>rt<"text-center"p>i',
        buttons: canExport ? [
            { extend: 'copy', exportOptions: { columns: ':not(:last-child)' } },
            { extend: 'csv', exportOptions: { columns: ':not(:last-child)' } },
            { extend: 'excel', exportOptions: { columns: ':not(:last-child)' } },
            {
                extend: 'print', exportOptions: { columns: ':not(:last-child)' },
                customize: function (win) {
                    $(win.document.body).prepend('<h1 style="text-align:center; color:#007bff;">Laboratory Records</h1>');
                    $(win.document.body).css('font-size', '14pt');
                    $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                }
            }
        ] : [],
        columns: [
            { data: 'id', visible: false }, // 👈 hide ID column
            { data: 'created_at' },
            { data: 'patient_name' },
            { data: 'doctor_name' },
            { data: 'category_name' },
            {
              data: 'report',
              render: function (data) {
                return data && data.length > 40 ? data.substr(0, 40) + '…' : (data || '');
              }
            },
            {
              data: 'lab_status',
              render: function (status) {
                let colorClass = '';
                switch (status) {
                  case 'queued':      colorClass = 'badge badge-warning'; break;
                  case 'in_progress': colorClass = 'badge badge-primary'; break;
                  case 'completed':   colorClass = 'badge badge-success'; break;
                  case 'error':       colorClass = 'badge badge-danger'; break;
                  default:            colorClass = 'badge badge-secondary';
                }
                return `<span class="${colorClass}">${status.replace('_',' ')}</span>`;
              }
            },
            {
              data: 'created_at',
              render: function (date) {
                let now = moment();
                let then = moment(date);
                let diffDays = now.diff(then, 'days');

                if (diffDays < 7) {
                  return diffDays + ' days';
                } else if (diffDays < 30) {
                  return Math.floor(diffDays / 7) + ' weeks';
                } else if (diffDays < 365) {
                  return Math.floor(diffDays / 30) + ' months';
                } else {
                  return Math.floor(diffDays / 365) + ' years';
                }
              }
            },
            {
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    let btns = '';
                    <?php if (canAccessMenu('laboratory_read', $this->session->userdata('user_role'))): ?>
                        btns += `<a href="<?= base_url('laboratory/view/') ?>${row.id}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a> `;
                    <?php endif; ?>
                    <?php if (canAccessMenu('laboratory_update', $this->session->userdata('user_role'))): ?>
                        btns += `<a href="<?= base_url('laboratory/edit/') ?>${row.id}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a> `;
                    <?php endif; ?>
                    <?php if (canAccessMenu('laboratory_delete', $this->session->userdata('user_role'))): ?>
                        btns += `<a href="<?= base_url('laboratory/delete/') ?>${row.id}" class="btn btn-sm btn-danger btn-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>`;
                    <?php endif; ?>
                    return btns;
                }
            }
        ],
        columnDefs: [
            { targets: 1, width: "10%" }, // Date
            { targets: 2, width: "15%" }, // Patient
            { targets: 3, width: "15%" }, // Doctor
            { targets: 4, width: "12%" }, // Category
            { targets: 5, width: "20%" }, // Report
            { targets: 6, width: "10%" }, // Status
            { targets: 7, width: "8%" },  // Age
            { targets: 8, width: "10%" }  // Actions
        ]
    });

    // Confirm Delete
    $(document).on("click", ".btn-delete", function (e) {
      e.preventDefault();
      const url = $(this).attr("href");
      Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        heightAuto: false,
        customClass: {
          confirmButton: 'btn btn-danger',
          cancelButton: 'btn btn-secondary ml-2'
        },
        buttonsStyling: false
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url;
        }
      });
    });

    // Reload table on entity change
    $('#entityFilter').on('change', function () {
      table.ajax.reload();
    });
  });
</script>
