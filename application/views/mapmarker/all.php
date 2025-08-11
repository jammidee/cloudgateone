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
 * CREATED DATE : August 07, 2025
 * ------------------------------------------------------------------------
 */

?>

<!-- Container Fluid -->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/markers/index">Map Markers</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Markers</li>
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
                    <!-- Left: Icon + Title -->
                    <div class="d-flex align-items-center mr-3">
                        <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                        <h6 class="m-0 font-weight-bold text-primary">Markers List</h6>
                    </div>

                    <!-- Middle: Filters -->
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

                    <!-- Right: Button -->
                    <?php if (canAccessMenu('mapmarker_create', $this->session->userdata('user_role'))): ?>
                        <a href="<?= site_url('mapmarker/create'); ?>" class="btn btn-sm btn-primary ml-auto">
                            <i class="fas fa-plus mr-1"></i> Add Marker
                        </a>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <!-- Mobile Layout -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                        <h6 class="m-0 font-weight-bold text-primary">Markers List</h6>
                    </div>
                    <?php if (canAccessMenu('marker_create', $this->session->userdata('user_role'))): ?>
                        <a href="<?= site_url('markers/create'); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-1"></i> Add Marker
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
                <table class="table table-sm align-items-center table-flush table-hover display nowrap" id="dataTableMarkers" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th style="width: 200px;">Name</th>
                            <th style="width: 300px;">Description</th>
                            <th style="width: 120px;">Latitude</th>
                            <th style="width: 120px;">Longitude</th>
                            <th style="width: 120px;">Category</th>
                            <th style="width: 120px;">Layer</th>
                            <th style="width: 80px;">Actions</th>
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
    const canExport = <?= canAccessMenu('marker_report', $this->session->userdata('user_role')) ? 'true' : 'false' ?>;

    // Default to current week
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

    const table = $('#dataTableMarkers').DataTable({
        responsive: true,
        pageLength: 25,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('mapmarker/fetchAllAjax'); ?>",
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
            { data: 'description' },
            { data: 'latitude' },
            { data: 'longitude' },
            { data: 'category' },
            { data: 'layer' },
            {
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    let btns = '';
                    <?php if (canAccessMenu('marker_read', $this->session->userdata('user_role'))): ?>
                        btns += `<a href="<?= base_url('markers/view/') ?>${row.id}?t=${Date.now()}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a> `;
                    <?php endif; ?>
                    <?php if (canAccessMenu('marker_update', $this->session->userdata('user_role'))): ?>
                        btns += `<a href="<?= base_url('markers/edit/') ?>${row.id}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a> `;
                    <?php endif; ?>
                    <?php if (canAccessMenu('marker_delete', $this->session->userdata('user_role'))): ?>
                        btns += `<a href="<?= base_url('markers/delete/') ?>${row.id}" class="btn btn-sm btn-danger btn-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>`;
                    <?php endif; ?>
                    return btns;
                }
            }
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

    // Refresh table when entity filter changes
    $('#entityFilter').on('change', function () {
        table.ajax.reload();
    });
});
</script>
