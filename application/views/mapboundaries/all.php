<?php

/**
 * ------------------------------------------------------------------------
 * Copyright (C) 2025 Lalulla OPC. All rights reserved.
 *
 * Copyright (c) 2017 - Jammi Dee (Joel M. Damaso) <jammi_dee@yahoo.com>
 * This file is part of the Lalulla System.
 *
 * Lalulla System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * ------------------------------------------------------------------------
 * PRODUCT NAME : CloudGate PHP Framework
 * AUTHOR       : Jammi Dee (Joel M. Damaso)
 * LOCATION     : Manila, Philippines
 * EMAIL        : jammi_dee@yahoo.com
 * CREATED DATE : August 10, 2025
 * ------------------------------------------------------------------------
 */

/**
 * Map Boundaries Management: All Boundaries View
 * - Supports server-side DataTables
 * - Includes Entity ID and Date Range filters
 * - Permission-based export options
 */
?>

<!-- Container Fluid -->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/mapboundaries/index">Map Boundaries</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Boundaries</li>
        </ol>
    </div>

    <?php
        $isDesktop = !preg_match('/(android|iphone|ipad|mobile)/i', $_SERVER['HTTP_USER_AGENT']);
    ?>

    <div class="col-lg-12">
        <div class="card mb-4">
            
            <?php if ($isDesktop): ?>
                <!-- Desktop / Large Display Layout -->
                <div class="card-header py-3 d-flex align-items-center justify-content-between flex-wrap">
                    <div class="d-flex align-items-center mr-3">
                        <i class="fas fa-draw-polygon text-primary mr-2"></i>
                        <h6 class="m-0 font-weight-bold text-primary">Map Boundaries List</h6>
                    </div>

                    <div class="d-flex align-items-center flex-wrap">
                        <div class="d-flex align-items-center mr-3">
                            <label class="mb-0 mr-2" style="white-space: nowrap;" for="dateRange">Date-Range</label>
                            <input type="text" id="dateRange" class="form-control form-control-sm" 
                                style="width: 180px;" 
                                placeholder="Select range" autocomplete="off">
                        </div>
                        <div class="d-flex align-items-center mr-3">
                            <label class="mb-0 mr-2" style="white-space: nowrap;" for="entityFilter">Entity-ID</label>
                            <input type="text" id="entityFilter" class="form-control form-control-sm" 
                                value="<?= esc($this->session->userdata('user_entity')) ?>" readonly>
                        </div>
                    </div>

                    <?php if (canAccessMenu('mapboundaries_create', $this->session->userdata('user_role'))): ?>
                        <a href="<?= site_url('mapboundaries/create'); ?>" class="btn btn-sm btn-primary ml-auto">
                            <i class="fas fa-plus mr-1"></i> Add Boundary
                        </a>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <!-- Mobile Layout -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-draw-polygon text-primary mr-2"></i>
                        <h6 class="m-0 font-weight-bold text-primary">Map Boundaries List</h6>
                    </div>
                    <?php if (canAccessMenu('mapboundaries_create', $this->session->userdata('user_role'))): ?>
                        <a href="<?= site_url('mapboundaries/create'); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-1"></i> Add Boundary
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
                            <input type="text" id="entityFilter" class="form-control" value="<?= esc($this->session->userdata('user_entity')) ?>" readonly>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="table-responsive p-3">
                <table class="table table-sm align-items-center table-flush table-hover display nowrap" id="dataTableBoundaries" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Layer</th>
                            <th>Category</th>
                            <th>Created At</th>
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
    const canExport = <?= canAccessMenu('mapboundaries_report', $this->session->userdata('user_role')) ? 'true' : 'false' ?>;

    let startDate = moment().startOf('week').format('YYYY-MM-DD');
    let endDate = moment().endOf('week').format('YYYY-MM-DD');

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

    const table = $('#dataTableBoundaries').DataTable({
        responsive: true,
        pageLength: 25,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('mapboundaries/fetchAllAjax'); ?>",
            type: "POST",
            data: function(d) {
                d.date_from = startDate;
                d.date_to = endDate;
                d.entityid = $('#entityFilter').val();
            }
        },
        order: [[0, 'asc']],
        dom: '<"text-center mb-2"B><"d-flex justify-content-between align-items-center mb-2"l f>rt<"text-center"p>i',
        buttons: canExport ? ['copy', 'csv', 'excel', 'pdf', 'print'] : [],
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'layer' },
            { data: 'category' },
            { data: 'created_at' },
            {
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    let btns = '';
                    <?php if (canAccessMenu('mapboundaries_read', $this->session->userdata('user_role'))): ?>
                        btns += `<a href="<?= base_url('mapboundaries/view/') ?>${row.id}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a> `;
                    <?php endif; ?>
                    <?php if (canAccessMenu('mapboundaries_update', $this->session->userdata('user_role'))): ?>
                        btns += `<a href="<?= base_url('mapboundaries/edit/') ?>${row.id}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a> `;
                    <?php endif; ?>
                    <?php if (canAccessMenu('mapboundaries_delete', $this->session->userdata('user_role'))): ?>
                        btns += `<a href="<?= base_url('mapboundaries/delete/') ?>${row.id}" class="btn btn-sm btn-danger btn-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>`;
                    <?php endif; ?>
                    return btns;
                }
            }
        ]
    });

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
});
</script>
