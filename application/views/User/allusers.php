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

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/user/index">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">All</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                <div class="d-flex align-items-center">

                    <i class="fas fa-users text-primary mr-2"></i>
                    <h6 class="m-0 font-weight-bold text-primary mr-3">User List</h6>

                </div>

                <!-- Add Button -->
                <?php if (canAccessMenu('user_create', $this->session->userdata('user_role'))): ?>
                    <a href="<?= base_url('user/add'); ?>" class="btn btn-sm btn-primary" id="btnAddUser">
                        <i class="fas fa-plus mr-1"></i> Add User
                    </a>
                <?php endif; ?>


            </div>

            <div class="table-responsive p-3">

                <!-- <form method="get" class="form-inline mb-3">
                    <label class="mr-2">Show</label>
                    <select name="limit" class="form-control mr-2" onchange="this.form.submit()">
                        <option <!= $limit == 5 ? 'selected' : '' ?>>5</option>
                        <option <!= $limit == 10 ? 'selected' : '' ?>>10</option>
                        <option <!= $limit == 25 ? 'selected' : '' ?>>25</option>
                        <option <!= $limit == 50 ? 'selected' : '' ?>>50</option>
                    </select>
                    <span>entries</span>
                </form> -->

                <table class="table table-sm align-items-center table-flush table-hover display nowrap" id="dataTableHolder" style="width:100%" >
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 25%;">Name</th>
                            <th style="width: 20%;">Position</th>
                            <th style="width: 15%;">UserID</th>
                            <th style="width: 15%;">Mobile</th>
                            <th style="width: 15%;">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>UserID</th>
                            <th>Mobile</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        <?php $i = 0; foreach ($users as $row) { $i++; ?>
                            <tr>
                                <td class=" "><?php echo $row->id; ?></td>
                                <td class=" "><?php echo $row->name; ?></td>
                                <td class=" "><?php echo $row->role; ?></td>
                                <td class=" "><?php echo $row->user_id; ?></td>
                                <td class=" "><?php echo $row->mobile; ?></td>

                                <!-- Actions -->
                                <td>
                                    <?php if (canAccessMenu('user_read', $this->session->userdata('user_role'))): ?>
                                        <a href="<?= base_url('/user/view/' . $row->id . '?t=' . time()); ?>"
                                            class="btn btn-sm btn-info"
                                            title="View"><i class="fas fa-eye"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (canAccessMenu('user_update', $this->session->userdata('user_role'))): ?>
                                        <a href="<?= base_url('/user/edit/' . $row->id . '?t=' . time()); ?>"
                                            class="btn btn-sm btn-primary ml-1"
                                            title="Edit"><i class="fas fa-edit"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (canAccessMenu('user_delete', $this->session->userdata('user_role'))): ?>
                                        <a href="<?= base_url('/user/delete/' . $row->id . '?t=' . time()); ?>"
                                            class="btn btn-sm btn-danger btn-delete ml-1"
                                            title="Delete"><i class="fas fa-trash-alt"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <!-- Actions -->

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>

                <!-- <div class="mt-3 text-right">
                    <!= $pagination_links; ?>
                </div> -->

            </div>
        </div>
    </div>



</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const canAccessbuttons = <?= canAccessMenu('user_report', $this->session->userdata('user_role')) ? 'true' : 'false' ?>;

        // Check if jQuery is loaded
        if (typeof jQuery === "undefined") {
            console.error("jQuery is not loaded. DataTables requires jQuery.");
            return;
        }

        // Initialize DataTable if target table exists
        if ($('#dataTableHolder').length) {
            $('#dataTableHolder').DataTable({
                responsive: true,
                pageLength: 25,
                lengthMenu: [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"] ],
                order: [],
                dom: '<"text-center mb-2"B><"d-flex justify-content-between align-items-center mb-2"l f>rt<"text-center"p>i',
                buttons: canAccessbuttons ? ['copy', 'csv', 'excel', 'pdf', 'print'] : [],
                columnDefs: [{
                    targets: 'nosort',
                    orderable: false
                }]
            });
        } else {
            console.warn("#dataTableHolder table not found.");
        }

        // Added click on delete button with SweetAlert
        document.querySelectorAll(".btn-delete").forEach(function (button) {
            button.addEventListener("click", function (e) {
                e.preventDefault(); // Prevent default anchor behavior

                const url = this.getAttribute("href");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    heightAuto: false, // Fix layout issue on mobile
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary ml-2'
                    },
                    buttonsStyling: false // Let Bootstrap handle button styles
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });

    });
</script>