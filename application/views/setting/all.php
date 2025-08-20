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
 * CREATED DATE : August 20, 2025
 * ------------------------------------------------------------------------
 */

?>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/setting/index">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">All</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-cogs text-primary mr-2"></i>
                    <h6 class="m-0 font-weight-bold text-primary mr-3">Settings List</h6>
                </div>

                <?php if (canAccessMenu('setting_update', $this->session->userdata('user_role'))): ?>
                    <a href="<?= site_url('setting/add/1'); ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus mr-1"></i> Add Settings
                    </a>
                <?php endif; ?>
            </div>

            <div class="table-responsive p-3">
                <table class="table table-sm align-items-center table-flush table-hover display nowrap" id="dataTableHolder" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 20%;">Name</th>
                            <th style="width: 20%;">Email</th>
                            <th style="width: 15%;">Mobile</th>
                            <th style="width: 10%;">Currency</th>
                            <th style="width: 15%;">City</th>
                            <th style="width: 15%;">Country</th>
                            <th style="width: 10%;">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Currency</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if (!empty($settings) && is_array($settings)): ?>
                            <?php foreach ($settings as $setting): ?>
                                <?php if (is_object($setting)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($setting->id ?? '') ?></td>
                                        <td><?= htmlspecialchars($setting->name ?? '') ?></td>
                                        <td><?= htmlspecialchars($setting->email ?? '') ?></td>
                                        <td><?= htmlspecialchars($setting->mobile ?? '') ?></td>
                                        <td><?= htmlspecialchars($setting->currency ?? '') ?></td>
                                        <td><?= htmlspecialchars($setting->city ?? '') ?></td>
                                        <td><?= htmlspecialchars($setting->country ?? '') ?></td>
                                        <td>
                                            <?php if (canAccessMenu('setting_read', $this->session->userdata('user_role'))): ?>
                                                <a href="<?= base_url('/setting/view/' . $setting->id . '?t=' . time()); ?>"
                                                    class="btn btn-sm btn-info"
                                                    title="View"><i class="fas fa-eye"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (canAccessMenu('setting_update', $this->session->userdata('user_role'))): ?>
                                                <a href="<?= base_url('/setting/edit/' . $setting->id . '?t=' . time()); ?>"
                                                    class="btn btn-sm btn-primary ml-1"
                                                    title="Edit"><i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (canAccessMenu('setting_delete', $this->session->userdata('user_role'))): ?>
                                                <a href="<?= base_url('/setting/delete/' . $setting->id . '?t=' . time()); ?>"
                                                    class="btn btn-sm btn-danger btn-delete ml-1"
                                                    title="Delete"><i class="fas fa-trash-alt"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center text-muted">No settings found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Container Fluid -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const canAccessbuttons = <?= canAccessMenu('setting_report', $this->session->userdata('user_role')) ? 'true' : 'false' ?>;

        if ($('#dataTableHolder').length) {
            $('#dataTableHolder').DataTable({
                responsive: true,
                pageLength: 25,
                lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
                order: [],
                dom: '<"text-center mb-2"B><"d-flex justify-content-between align-items-center mb-2"l f>rt<"text-center"p>i',
                buttons: canAccessbuttons ? ['copy', 'csv', 'excel', 'pdf', 'print'] : [],
                columnDefs: [{
                    targets: 'nosort',
                    orderable: false
                }]
            });
        }

        document.querySelectorAll(".btn-delete").forEach(function (button) {
            button.addEventListener("click", function (e) {
                e.preventDefault();
                const url = this.getAttribute("href");

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
    });
</script>
