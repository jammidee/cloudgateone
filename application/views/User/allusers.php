<?php
/**
 * ------------------------------------------------------------------------
 * Copyright (C) 2025 Lalulla OPC. All rights reserved.
 *
 * Copyright (c) 2017 - Jammi Dee (Joel M. Damaso)
 * This file is part of the Lalulla System.
 *
 * Lalulla System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 * ------------------------------------------------------------------------
 * PRODUCT NAME : CloudGate PHP Framework
 * AUTHOR       : Jammi Dee (Joel M. Damaso)
 * LOCATION     : Manila, Philippines
 * EMAIL        : jammi_dee@yahoo.com
 * CREATED DATE : August 07, 2025
 * ------------------------------------------------------------------------
 */
?>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="h4 mb-0 text-gray-800"><?= $title; ?></h4>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item"><a href="/user/index">Users</a></li>
      <li class="breadcrumb-item active" aria-current="page">All</li>
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
          <i class="fas fa-users text-primary mr-2"></i>
          <h6 class="m-0 font-weight-bold text-primary">User List</h6>
        </div>

        <!-- Right: Add Button -->
        <?php if (canAccessMenu('user_create', $this->session->userdata('user_role'))): ?>
        <a href="<?= base_url('user/add'); ?>" class="btn btn-sm btn-primary ml-auto" id="btnAddUser">
          <i class="fas fa-plus mr-1"></i> Add User
        </a>
        <?php endif; ?>
      </div>
      <?php else: ?>
      <!-- Mobile Layout -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <i class="fas fa-users text-primary mr-2"></i>
          <h6 class="m-0 font-weight-bold text-primary">User List</h6>
        </div>
        <?php if (canAccessMenu('user_create', $this->session->userdata('user_role'))): ?>
        <a href="<?= base_url('user/add'); ?>" class="btn btn-sm btn-primary" id="btnAddUser">
          <i class="fas fa-plus mr-1"></i> Add User
        </a>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <div class="table-responsive p-3">
        <table class="table table-sm align-items-center table-flush table-hover display nowrap"
          id="dataTableUsers" style="width:100%">
          <thead class="thead-light">
            <tr>
              <th>ID</th> <!-- 👈 hidden -->
              <th>Name</th>
              <th>Position</th>
              <th>UserID</th>
              <th>Mobile</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!---Container Fluid-->

<script>
document.addEventListener("DOMContentLoaded", function () {
    const canExport = <?= canAccessMenu('user_report', $this->session->userdata('user_role')) ? 'true' : 'false' ?>;

    // Initialize DataTable with server-side processing
    const table = $('#dataTableUsers').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: {
            url: "<?= base_url('user/fetchAllAjax'); ?>",
            type: "POST",
            data: function(d) {
                // d.date_from = startDate;
                // d.date_to = endDate;
                d.entityid = $('#entityFilter').val();
                d.searchText = d.search.value;
            }
        },
        dom: '<"text-center mb-2"B><"d-flex justify-content-between align-items-center mb-2"lf>rt<"text-center"p>i',
        buttons: canExport ? ['copy', 'csv', 'excel', 'pdf', 'print'] : [],
        columns: [
            { data: 'id', visible: false }, // 👈 hide ID column
            { data: 'name' },
            { data: 'role' },
            { data: 'user_id' },
            { data: 'mobile' },
            {
                data: null,
                orderable: false,
                render: function(data, type, row) {
                    let btns = '';
                    <?php if (canAccessMenu('user_read', $this->session->userdata('user_role'))): ?>
                        btns += `<a href="<?= base_url('user/view/') ?>${row.id}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a> `;
                    <?php endif; ?>
                    <?php if (canAccessMenu('user_update', $this->session->userdata('user_role'))): ?>
                        btns += `<a href="<?= base_url('user/edit/') ?>${row.id}" class="btn btn-sm btn-primary ml-1" title="Edit"><i class="fas fa-edit"></i></a> `;
                    <?php endif; ?>
                    <?php if (canAccessMenu('user_delete', $this->session->userdata('user_role'))): ?>
                        btns += `<a href="<?= base_url('user/delete/') ?>${row.id}" class="btn btn-sm btn-danger ml-1 btn-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>`;
                    <?php endif; ?>
                    return btns;
                }
            }
        ],
        columnDefs: [
            { targets: 1, width: "180px" },
            { targets: 2, width: "160px" },
            { targets: 3, width: "120px" },
            { targets: 4, width: "150px" },
            { targets: 5, width: "130px" }
        ]
    });

    // SweetAlert Delete Confirmation
    $(document).on("click", ".btn-delete", function(e) {
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
        }).then((result) => { if (result.isConfirmed) window.location.href = url; });
    });

});
</script>
